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

- **`Configuration/`** — `ConfigurationInterface`/`Configuration` (host, username, API token) and `ConfigurationFactory::create(array)` for building one from a plain config array (used by both manual instantiation and the bundle's DI wiring).
- **`Http/`** — `JiraClientInterface`/`JiraClient`: a thin wrapper around Symfony's `HttpClient` (`ScopingHttpClient` bound to `{host}/rest/api/3/`), adding `auth_basic` only when both username and password are set. `JiraClient` is a `readonly class`.
- **`Repository/`** — one repository per Jira resource (`Issue`, `IssueComment`, `CustomFieldOption`, `Project`, `Version`), each with an `*Interface` and a concrete `readonly class` extending `abstract readonly class AbstractRepository`. `AbstractRepository` holds the `JiraClientInterface` + `SerializerInterface` and exposes `protected serialize()/deserialize()` helpers. **Note:** PHP 8.2 requires every class extending a `readonly class` to itself be declared `readonly` — keep that when adding a new repository.
- **`Model/`** — plain DTOs mirroring Jira's JSON shapes, organized by domain (`Issue/`, `Project/`, `User/`, `Version/`, `Status/`, `Workflow/`, `Avatar/`). These are intentionally mutable (fluent setters), since the same class is used both to deserialize API responses and to build write payloads.
- **`Enum/`** — plain backed string enums (no methods); marked `@codeCoverageIgnore` since they have zero executable statements.
- **`Exception/`** — domain-specific exceptions thrown as guards inside repository methods (e.g. `CommentBodyEmptyException`, `VersionMustBeExistsException`).
- **`Serializer/`** — `SerializerFactory::create()` builds the Symfony `Serializer` used by every repository by default (unless one is injected), including two custom normalizers:
  - `FieldsNormalizer` handles Jira's dynamic `customfield_XXXXX` keys on issue fields (arbitrary custom field IDs used as object keys, not modelable as fixed properties).
  - `CommentNormalizer` and `FieldsNormalizer` both also handle Atlassian Document Format (ADF) rich-text nodes (`Comment::$body`, `Fields::$description`) via the `DH\Adf\Node\Block\Document` class from the `xen3r0/adf-tools` dependency, since ADF documents need `Document::load()`/`jsonSerialize()` rather than generic object (de)normalization.

### The `WRITE_GROUP` pattern

Several models that are both read from and written to the API (`Comment`, `Version`, `CustomFieldOption`) declare a `public const WRITE_GROUP` and tag the writable properties with `#[Groups(groups: [self::WRITE_GROUP])]`. Repository methods that POST/PUT pass `['groups' => X::WRITE_GROUP]` as serialization context so only the intended subset of properties is sent, instead of the full deserialized shape. Follow this pattern for any new model that needs both directions.

### Tests

`tests/` mirrors `src/`'s structure 1:1. Repository tests mock `JiraClientInterface`/`ResponseInterface` and read fixture JSON from `tests/Repository/Fixtures/`; `JiraClientTest` instead uses Symfony's `MockHttpClient` since it exercises the real HTTP wiring (base URI, auth, headers) rather than repository logic. Model/DTO tests are plain getter/setter round-trip assertions — no mocking needed there.
