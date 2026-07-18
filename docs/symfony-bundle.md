# Symfony Bundle

You can also use this library as a Symfony bundle, you don't need to add another package to your composer dependencies.

- [Registering the Bundle](#registering-the-bundle)
- [Configuration](#configuration)
- [Usage](#usage)

## Registering the Bundle

To register the bundle, add it to your `config/bundles.php` file:

```php
return [
    // ...
    Xen3r0\JiraApiClient\Symfony\Bundle\JiraApiClientBundle::class => ['all' => true],
];
```

## Configuration

Then, configure the bundle in your `config/packages/jira_api_client.yaml` file:

```yaml
jira_api_client:
    http:
        host: 'https://your-jira-instance.atlassian.net'
        username: 'your-username'
        password: 'your-api-token'
```

Or, with a bearer token (Personal Access Token or OAuth 2.0 access token) instead of Basic Auth — `token` takes precedence over `username`/`password` when both are set:

```yaml
jira_api_client:
    http:
        host: 'https://your-jira-instance.atlassian.net'
        token: 'your-bearer-token'
```

## Usage

You can now use every repository as a service in your Symfony application. For example, to use the `IssueRepository`:

```php
use Xen3r0\JiraApiClient\Repository\Issue\IssueRepositoryInterface;

#[Route('/some-route', name: 'some_route')]
class SomeController
{
    public function __construct(
        private readonly IssueRepositoryInterface $issueRepository,
    ) {
    }

    public function __invoke(): void
    {
        $issue = $this->issueRepository->findByIdOrKey('PROJECT-123');
        // Do something with the issue...
    }
}
```

See [repositories.md](repositories.md) for the full list of available repositories.
