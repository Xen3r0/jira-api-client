<?php

namespace Xen3r0\JiraApiClient\Repository\Issue;

use Xen3r0\JiraApiClient\Exception\Issue\IssueMustBeExistsException;
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

    public function create(Issue $issue): ?Issue;

    /**
     * @throws IssueMustBeExistsException
     */
    public function update(Issue $issue): void;

    public function delete(string $idOrKey): void;
}
