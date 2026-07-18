# Getting started

- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Usage](#usage)

## Prerequisites

This library requires PHP 8.2 or higher and the following PHP extensions:
- `dom`
- `json`
- `xml`

## Installation

Add [xen3r0/jira-api-client](https://packagist.org/packages/xen3r0/jira-api-client) to your `composer.json` file:

```bash
composer require xen3r0/jira-api-client
```

## Usage

Create a new instance of the `JiraClient` class:

```php
use Xen3r0\JiraApiClient\Configuration\Configuration;
use Xen3r0\JiraApiClient\Configuration\ConfigurationFactory;
use Xen3r0\JiraApiClient\Http\JiraClient;

$configuration = ConfigurationFactory::create([
    'host' => 'https://your-jira-instance.atlassian.net',
    'username' => 'your-username',
    'password' => 'your-api-token',
]);
$client = new JiraClient($configuration);
```

You can also authenticate with a bearer token — a Jira Personal Access Token or an OAuth 2.0 (3LO) access token you've already obtained — instead of Basic Auth. When a token is set, it takes precedence over `username`/`password`:

```php
$configuration = Configuration::createWithToken('https://your-jira-instance.atlassian.net', 'your-bearer-token');
$client = new JiraClient($configuration);
```

Now, you can use some repositories, for example, `IssueRepository`:

```php
use Xen3r0\JiraApiClient\Repository\Issue\IssueRepository;

$issueRepository = new IssueRepository($client);
$issue = $issueRepository->findByIdOrKey('PROJECT-123');
```

See [repositories.md](repositories.md) for the full list of available repositories.
