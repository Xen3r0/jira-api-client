# Jira API Client

[![CI](https://github.com/Xen3r0/jira-api-client/actions/workflows/ci.yml/badge.svg)](https://github.com/Xen3r0/jira-api-client/actions/workflows/ci.yml)

**Jira API Client** is a modern PHP library that provides a simple and fluent interface to interact with the Jira API, usable standalone or as a Symfony bundle.

## Documentation
- [Getting started](docs/getting-started.md) — prerequisites, installation, and standalone usage.
- [Symfony Bundle](docs/symfony-bundle.md) — registering the bundle, configuration, and usage.
- [Repositories](docs/repositories.md) — the list of available repositories.
- [Changelog](CHANGELOG.md) — history of notable changes.
- [Contributing](CONTRIBUTING.md) — how to contribute, and the release process.

## Quick start

```bash
composer require xen3r0/jira-api-client
```

```php
use Xen3r0\JiraApiClient\Configuration\ConfigurationFactory;
use Xen3r0\JiraApiClient\Http\JiraClient;
use Xen3r0\JiraApiClient\Repository\Issue\IssueRepository;

$configuration = ConfigurationFactory::create([
    'host' => 'https://your-jira-instance.atlassian.net',
    'username' => 'your-username',
    'password' => 'your-api-token',
]);
$client = new JiraClient($configuration);

$issueRepository = new IssueRepository($client);
$issue = $issueRepository->findByIdOrKey('PROJECT-123');
```

See [Getting started](docs/getting-started.md) for the full walkthrough, including Bearer token / OAuth 2.0 authentication.

## Credits
- [Manuel Santisteban](https://github.com/Xen3r0)

## License
This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
