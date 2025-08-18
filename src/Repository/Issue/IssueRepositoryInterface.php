<?php

namespace Xen3r0\JiraApiClient\Repository\Issue;

use Xen3r0\JiraApiClient\Model\Issue\Issue;
use Xen3r0\JiraApiClient\Model\Issue\IssueSearchResult;

interface IssueRepositoryInterface
{
    public function findAll(string $jql, int $maxResults = 15, ?string $nextPageToken = null): IssueSearchResult;

    public function findByIdOrKey(string $id): ?Issue;
}
