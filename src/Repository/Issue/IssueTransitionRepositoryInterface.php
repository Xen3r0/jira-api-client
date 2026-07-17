<?php

namespace Xen3r0\JiraApiClient\Repository\Issue;

use Xen3r0\JiraApiClient\Model\Issue\TransitionSearchResult;

/**
 * @codeCoverageIgnore
 */
interface IssueTransitionRepositoryInterface
{
    public function findAll(string $issueIdOrKey): TransitionSearchResult;

    public function transition(string $issueIdOrKey, string $transitionId): void;
}
