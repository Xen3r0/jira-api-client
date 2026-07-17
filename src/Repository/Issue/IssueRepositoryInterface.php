<?php

namespace Xen3r0\JiraApiClient\Repository\Issue;

use Xen3r0\JiraApiClient\Model\Issue\Issue;
use Xen3r0\JiraApiClient\Model\Issue\IssueSearchResult;

/**
 * @codeCoverageIgnore
 */
interface IssueRepositoryInterface
{
    /**
     * @param array<int, string> $fields
     */
    public function findAll(string $jql, int $maxResults = 15, ?string $nextPageToken = null, array $fields = ['*all']): IssueSearchResult;

    public function findByIdOrKey(string $id): ?Issue;
}
