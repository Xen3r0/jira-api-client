<?php

namespace Xen3r0\JiraApiClient\Repository\Issue;

use Xen3r0\JiraApiClient\Model\Issue\Worklog;
use Xen3r0\JiraApiClient\Model\Issue\WorklogSearchResult;

/**
 * @codeCoverageIgnore
 */
interface WorklogRepositoryInterface
{
    public function findAll(string $issueIdOrKey, int $startAt = 0, int $maxResults = 50): WorklogSearchResult;

    public function findById(string $issueIdOrKey, string $id): ?Worklog;

    public function add(string $issueIdOrKey, Worklog $worklog): ?Worklog;

    public function update(string $issueIdOrKey, Worklog $worklog): ?Worklog;

    public function remove(string $issueIdOrKey, string $id): void;
}
