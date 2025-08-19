<?php

namespace Xen3r0\JiraApiClient\Repository\Issue;

use Xen3r0\JiraApiClient\Enum\Issue\IssueCommentOrder;
use Xen3r0\JiraApiClient\Model\Issue\Comment;
use Xen3r0\JiraApiClient\Model\Issue\CommentSearchResult;

interface IssueCommentRepositoryInterface
{
    public function findAll(string $issueKey, ?IssueCommentOrder $orderBy = null, int $startAt = 0, int $maxResults = 15): CommentSearchResult;

    public function findById(string $issueKey, string $id): ?Comment;

    public function add(string $issueKey, Comment $comment): ?Comment;
}
