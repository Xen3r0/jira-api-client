# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project overview

`xen3r0/jira-api-client` is a PHP 8.2+ library providing a fluent client for the Jira Cloud REST API (v3), usable either standalone or as a Symfony bundle. It has no other runtime framework dependency for its core usage.

## Commands

A Docker dev environment is provided (PHP 8.2 CLI, Composer, Xdebug) so none of this requires a local PHP install:

```bash
docker compose up -d
docker compose exec php composer install
```

Run all commands below inside the container (prefix with `docker compose exec php`), or directly if you have a matching local PHP toolchain.

```bash
# Run the full test suite
vendor/bin/phpunit

# Run a single test file / a single test method
vendor/bin/phpunit tests/Repository/Issue/IssueRepositoryTest.php
vendor/bin/phpunit --filter testFindByIdOrKey

# Static analysis (PHPStan, level 8). The default 128M memory_limit in the
# container image can be too low for the parallel analysis; pass a higher
# limit if it OOMs:
vendor/bin/phpstan analyse
vendor/bin/phpstan analyse --memory-limit=512M

# Coding standards (php-cs-fixer, @Symfony ruleset)
vendor/bin/php-cs-fixer fix --dry-run --diff   # check only, matches CI
vendor/bin/php-cs-fixer fix                    # auto-fix

# Coverage report (Xdebug is installed but disabled by default in the
# container; enable it for the run via XDEBUG_MODE)
XDEBUG_MODE=coverage vendor/bin/phpunit --coverage-text
```

CI (`.github/workflows/ci.yml`) runs `coding-standards` once on PHP 8.2 only (style/static analysis are version-independent) and `tests` across the PHP 8.2/8.3/8.4 matrix; coverage is only collected on the 8.2 leg and written to the job's `$GITHUB_STEP_SUMMARY` (not posted as a PR comment, to avoid emailing every watcher on each push).

## Architecture

### Two consumption modes, one core

The library can be used standalone (`new JiraClient($configuration)` + `new XRepository($client)`) or registered as a Symfony bundle (`Xen3r0\JiraApiClient\Symfony\Bundle\JiraApiClientBundle`), which wires the same classes as DI services. The bundle is optional glue, not a separate implementation — `src/Symfony/Bundle/` only contains the `Bundle`/`Extension`/`Configuration` classes and `Resources/config/*.php` (Symfony DI config written as PHP, not YAML) that register services from the rest of `src/`.

### Layers under `src/`

- **`Configuration/`** — `ConfigurationInterface`/`Configuration` (host, username/password, and a `token` field for Bearer auth) with two named factory methods, `Configuration::createWithBasic()` and `Configuration::createWithToken()`, plus `ConfigurationFactory::create(array)` for building one from a plain config array (used by both manual instantiation and the bundle's DI wiring).
- **`Http/`** — `JiraClientInterface`/`JiraClient`: a thin wrapper around Symfony's `HttpClient` (`ScopingHttpClient` bound to `{host}/rest/api/3/`, then wrapped in `RetryableHttpClient` with a `GenericRetryStrategy` scoped to `[429]` — order matters, `RetryableHttpClient` must wrap `ScopingHttpClient`, not the reverse, or base_uri resolution breaks on retry). Auth is picked implicitly, no `authType` field: `auth_bearer` when `Configuration::getToken()` is set, otherwise `auth_basic` when both username and password are set. `request()` eagerly reads response headers and converts `HttpExceptionInterface` into `JiraApiException` (parsed from Jira's error JSON body); pure transport errors propagate unwrapped. `JiraClient` is a `readonly class`.
- **`Repository/`** — one repository per Jira resource (`Issue`, `IssueComment`, `IssueTransition`, `IssueLink`, `LinkType`, `CustomFieldOption`, `Project`, `Version`, `Component`, `User`), each with an `*Interface` and a concrete `readonly class` extending `abstract readonly class AbstractRepository`. `AbstractRepository` holds the `JiraClientInterface` + `SerializerInterface` and exposes `protected serialize()/deserialize()/deserializeList()` helpers (`deserializeList()` is for endpoints like `user/search` that return a bare JSON array instead of the usual `{startAt,maxResults,total,values}` envelope). **Note:** PHP 8.2 requires every class extending a `readonly class` to itself be declared `readonly` — keep that when adding a new repository.
- **`Model/`** — plain DTOs mirroring Jira's JSON shapes, organized by domain (`Issue/`, `Project/`, `User/`, `Version/`, `Status/`, `Workflow/`, `Avatar/`). These are intentionally mutable (fluent setters), since the same class is used both to deserialize API responses and to build write payloads.
- **`Enum/`** — plain backed string enums (no methods); marked `@codeCoverageIgnore` since they have zero executable statements.
- **`Exception/`** — domain-specific exceptions thrown as guards inside repository methods (e.g. `CommentBodyEmptyException`, `VersionMustBeExistsException`, `IssueMustBeExistsException`), plus `Exception/Http/JiraApiException` (status code + `errorMessages`/`errors` parsed from Jira's error body, built via `JiraApiException::fromResponse()`).
- **`Serializer/`** — `SerializerFactory::create()` builds the Symfony `Serializer` used by every repository by default (unless one is injected), including two custom normalizers:
  - `FieldsNormalizer` handles Jira's dynamic `customfield_XXXXX` keys on issue fields (arbitrary custom field IDs used as object keys, not modelable as fixed properties).
  - `CommentNormalizer` and `FieldsNormalizer` both also handle Atlassian Document Format (ADF) rich-text nodes (`Comment::$body`, `Fields::$description`) via the `DH\Adf\Node\Block\Document` class from the `xen3r0/adf-tools` dependency, since ADF documents need `Document::load()`/`jsonSerialize()` rather than generic object (de)normalization.
- **`Pagination/`** — `Paginator::byOffset()`/`byCursor()`, generic generators that chain paged `find*()` calls into a single `iterable`. `OffsetPaginatedResultInterface` (`getStartAt()`/`getTotal()`) and `CursorPaginatedResultInterface` (`getIsLast()`/`getNextPageToken()`) are marker interfaces implemented by the search-result envelope classes (`IssueSearchResult`, `ProjectSearchResult`, `CommentSearchResult`, `CustomFieldOptionSearchResult`); "done" for offset pagination is computed as `startAt + count(items) >= total` rather than relying on `isLast`, since not every envelope has it.

### The `WRITE_GROUP` pattern

Several models that are both read from and written to the API (`Comment`, `Version`, `CustomFieldOption`, `Fields`, `Component`, `Link`) declare a `public const WRITE_GROUP` and tag the writable properties with `#[Groups(groups: [self::WRITE_GROUP])]`. Repository methods that POST/PUT pass `['groups' => X::WRITE_GROUP]` as serialization context so only the intended subset of properties is sent, instead of the full deserialized shape. Follow this pattern for any new model that needs both directions.

Symfony Serializer's `groups` filtering applies **recursively** through the whole object graph: a nested object (e.g. `Issue` nested inside `Fields`, or `Project`/`Type` nested inside `Fields`) needs its own matching `Groups` tag on the specific properties needed, or it gets stripped to `{}` entirely. This is why some identifier-only properties carry a `Groups` tag for a WRITE_GROUP that "belongs" to a different domain (e.g. `Project::$key`, `Issue\Type::$id`, `Issue::$key`, `LinkType::$name`) — each is tagged for every WRITE_GROUP that needs to serialize it as a nested reference. A property can carry multiple `Groups` tags without conflict.

### Tests

`tests/` mirrors `src/`'s structure 1:1. Repository tests mock `JiraClientInterface`/`ResponseInterface` and read fixture JSON from `tests/Repository/Fixtures/`; `JiraClientTest` instead uses Symfony's `MockHttpClient` since it exercises the real HTTP wiring (base URI, auth, headers) rather than repository logic. Model/DTO tests are plain getter/setter round-trip assertions — no mocking needed there.
