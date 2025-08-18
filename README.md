# Jira API Client

[![CI](https://github.com/Xen3r0/jira-api-client/actions/workflows/ci.yml/badge.svg)](https://github.com/Xen3r0/jira-api-client/actions/workflows/ci.yml)

**Jira API Client** is a modern PHP library that provides a simple and fluent interface to interact with the Jira API.

# Getting started

## Prerequisites

This library requires PHP 8.1 or higher and the following PHP extensions:
- `dom`
- `json`
- `xml`

## Installation

Add `xen3r0/jira-api-client` to your `composer.json` file:

```bash
php composer.phar require xen3r0/jira-api-client
```

## Usage

Create a new instance of the `JiraClient` class:

```php
use Xen3r0\JiraApiClient\Configuration\ConfigurationFactory;
use Xen3r0\JiraApiClient\Http\JiraClient;

$configuration = ConfigurationFactory::create([
    'host' => 'https://your-jira-instance.atlassian.net',
    'username' => 'your-username',
    'password' => 'your-api-token',
]);
$client = new JiraClient($configuration);
```

Now, you can use some repositories, for example, `IssueRepository`:

```php
use Xen3r0\JiraApiClient\Repository\IssueRepository;

$issueRepository = new IssueRepository($client);
$issue = $issueRepository->get('PROJECT-123');
```

# Repositories

This livrary provides several repositories to interact with different Jira API endpoints. Here are some of the available repositories:
- `CustomFieldOptionRepository`: Manage custom field options in Jira.
- `IssueCommentRepository`: Manage comments on issues in Jira.
- `IssueRepository`: Manage issues in Jira.
- `ProjectRepository`: Manage projects in Jira.
- `VersionRepository`: Manage versions in Jira.

A repository is missing ? You can suggest a new repository by opening an issue and/or pull request.

# Contributing

See the [CONTRIBUTING.md](CONTRIBUTING.md) file for details on how to contribute to this project.

# Credits
- [Manuel Santisteban](https://github.com/Xen3r0)

# License
This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details
