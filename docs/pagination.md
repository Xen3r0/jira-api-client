# Pagination

Jira Cloud's paginated endpoints come in two flavours:

- **Offset-based** (`startAt`/`maxResults`/`total`) — used by e.g. `project/search`, `issue/{id}/comment`, `issue/{id}/worklog`, `field/{id}/context/{id}/option`.
- **Cursor-based** (`nextPageToken`/`isLast`) — used by the newer `search/jql` endpoint (issues).

`Xen3r0\JiraApiClient\Pagination\Paginator` gives you one generic way to iterate over either kind, without manually tracking `startAt` or `nextPageToken` yourself. It returns a lazy `iterable`: pages are only fetched as you consume items, so `break`-ing out of the loop early stops making requests.

- [Offset-based pagination](#offset-based-pagination)
- [Cursor-based pagination](#cursor-based-pagination)
- [Stopping early](#stopping-early)
- [Which repositories support pagination](#which-repositories-support-pagination)

## Offset-based pagination

`Paginator::byOffset()` takes two callables: one that fetches a page given a `startAt`, and one that extracts the items from that page. It keeps calling `$fetchPage` with an incrementing `startAt` until the page's `total` is reached or a page comes back empty.

```php
use Xen3r0\JiraApiClient\Pagination\Paginator;
use Xen3r0\JiraApiClient\Model\Project\Project;
use Xen3r0\JiraApiClient\Model\Project\ProjectSearchResult;
use Xen3r0\JiraApiClient\Repository\Project\ProjectRepository;

$projectRepository = new ProjectRepository($client);

$projects = Paginator::byOffset(
    fetchPage: static fn (int $startAt): ProjectSearchResult => $projectRepository->findAll(startAt: $startAt),
    extractItems: static fn (ProjectSearchResult $page): array => $page->getValues(),
);

/** @var Project $project */
foreach ($projects as $project) {
    echo $project->getKey().PHP_EOL;
}
```

The same pattern applies to any offset-paginated repository, for example every comment on an issue:

```php
use Xen3r0\JiraApiClient\Model\Issue\Comment;
use Xen3r0\JiraApiClient\Model\Issue\CommentSearchResult;
use Xen3r0\JiraApiClient\Repository\Issue\IssueCommentRepository;

$commentRepository = new IssueCommentRepository($client);

$comments = Paginator::byOffset(
    fetchPage: static fn (int $startAt): CommentSearchResult => $commentRepository->findAll('PROJECT-123', startAt: $startAt),
    extractItems: static fn (CommentSearchResult $page): array => $page->getComments(),
);

/** @var Comment $comment */
foreach ($comments as $comment) {
    // ...
}
```

## Cursor-based pagination

`Paginator::byCursor()` takes a callable that fetches a page given the previous page's token (`null` for the first page), and one that extracts the items. It keeps following `nextPageToken` until the page reports `isLast`.

```php
use Xen3r0\JiraApiClient\Model\Issue\Issue;
use Xen3r0\JiraApiClient\Model\Issue\IssueSearchResult;
use Xen3r0\JiraApiClient\Repository\Issue\IssueRepository;

$issueRepository = new IssueRepository($client);

$issues = Paginator::byCursor(
    fetchPage: static fn (?string $pageToken): IssueSearchResult => $issueRepository->findAll('project = PROJECT', nextPageToken: $pageToken),
    extractItems: static fn (IssueSearchResult $page): array => $page->getIssues(),
);

/** @var Issue $issue */
foreach ($issues as $issue) {
    echo $issue->getKey().PHP_EOL;
}
```

## Stopping early

Both helpers return a PHP generator, so pages are fetched lazily, one at a time, as the loop consumes items — not all upfront. `break`ing out of the `foreach` (e.g. once you've found what you're looking for) simply stops the `Paginator` from fetching any further page:

```php
foreach ($issues as $issue) {
    if ($issue->getKey() === 'PROJECT-123') {
        break; // no more pages are fetched after this
    }
}
```

## Which repositories support pagination

| Repository                 | `findAll()` style | Envelope                    |
|-----------------------------|--------------------|------------------------------|
| `ProjectRepository`          | Offset             | `ProjectSearchResult`         |
| `IssueCommentRepository`     | Offset             | `CommentSearchResult`         |
| `WorklogRepository`          | Offset             | `WorklogSearchResult`         |
| `CustomFieldOptionRepository`| Offset             | `CustomFieldOptionSearchResult`|
| `IssueRepository`            | Cursor             | `IssueSearchResult`           |

Any envelope implementing `OffsetPaginatedResultInterface` (`getStartAt()`/`getTotal()`) works with `Paginator::byOffset()`; any envelope implementing `CursorPaginatedResultInterface` (`getIsLast()`/`getNextPageToken()`) works with `Paginator::byCursor()`.
