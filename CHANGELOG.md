# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [0.3.0] - 2026-07-18

### Added
- `Configuration::createWithToken()` and a `token` field on `Configuration`/`JiraClient` to authenticate with a Bearer token (Jira Personal Access Token or an OAuth 2.0 3LO access token), on top of the existing Basic Auth. When set, it takes precedence over `username`/`password`. Wired into the Symfony bundle via a new `http.token` config key.
- `IssueRepository::create()`, `update()` and `delete()`, plus `IssueTransitionRepository` to list and execute workflow transitions on an issue.
- `UserRepository` (`findMyself()`, `findByAccountId()`, `search()`), `ComponentRepository`, `IssueLinkRepository` and `LinkTypeRepository`.
- `JiraApiException`, thrown with the status code and the `errorMessages`/`errors` parsed from Jira's error response body, instead of a generic HTTP exception swallowing the error details.
- Automatic retry with backoff on HTTP 429 responses (`JiraClient` now wraps requests in a `RetryableHttpClient`, configurable via a new `maxRetries` constructor argument, default 3).
- `Paginator::byOffset()`/`byCursor()`, generic helpers to iterate over every page of a paginated Jira endpoint without manually tracking `startAt`/`nextPageToken`.
- `AttachmentRepository` (`add()`, `findById()`, `remove()`, `getContent()`) to manage issue attachments, plus `JiraClientInterface::postMultipart()` to support the multipart/form-data upload it requires.

### Fixed
- `IssueRepository::findAll()` no longer silently returns issues with only their `id` populated: it now accepts a `fields` parameter (defaulting to `['*all']`) instead of always sending an empty `fields` array to `search/jql`.

### Changed
- `Configuration::create()` renamed to `Configuration::createWithBasic()`, for symmetry with `createWithToken()`.

## [0.2.2] - 2025-08-22
### Fixed
- Comment normalizer no longer loses the ADF body when round-tripping a `Comment` ([#5](https://github.com/Xen3r0/jira-api-client/pull/5)).

## [0.2.1] - 2025-08-19
### Fixed
- `JiraClient` now accepts an injected Symfony `HttpClient` instead of always building its own.
- `IssueRepository` search query construction.

## [0.2.0] - 2025-08-19
### Added
- Symfony bundle: `JiraApiClientBundle`, DI extension and configuration, wiring the library's services for Symfony applications ([#2](https://github.com/Xen3r0/jira-api-client/pull/2)).

## [0.1.0] - 2025-08-18
### Added
- Initial release: `JiraClient`, `Configuration`/`ConfigurationFactory`, and the first set of repositories (`Issue`, `IssueComment`, `CustomFieldOption`, `Project`, `Version`) ([#1](https://github.com/Xen3r0/jira-api-client/pull/1)).

[Unreleased]: https://github.com/Xen3r0/jira-api-client/compare/0.3.0...HEAD
[0.3.0]: https://github.com/Xen3r0/jira-api-client/compare/0.2.2...0.3.0
[0.2.2]: https://github.com/Xen3r0/jira-api-client/compare/0.2.1...0.2.2
[0.2.1]: https://github.com/Xen3r0/jira-api-client/compare/0.2.0...0.2.1
[0.2.0]: https://github.com/Xen3r0/jira-api-client/compare/0.1.0...0.2.0
[0.1.0]: https://github.com/Xen3r0/jira-api-client/releases/tag/0.1.0
