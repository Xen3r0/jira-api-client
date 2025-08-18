<?php

namespace Xen3r0\JiraApiClient\Repository\Issue;

use Xen3r0\JiraApiClient\Enum\Issue\IssueCommentOrder;
use Xen3r0\JiraApiClient\Exception\Issue\CommentBodyEmptyException;
use Xen3r0\JiraApiClient\Model\Issue\Comment;
use Xen3r0\JiraApiClient\Model\Issue\CommentSearchResult;
use Xen3r0\JiraApiClient\Repository\AbstractRepository;

class IssueCommentRepository extends AbstractRepository implements IssueCommentRepositoryInterface
{
    public function findAll(string $issueKey, ?IssueCommentOrder $orderBy = null, int $startAt = 0, int $maxResults = 15): CommentSearchResult
    {
        $response = $this->client->get(
            sprintf('issue/%s/comment', $issueKey),
            [
                'query' => [
                    'orderBy' => $orderBy,
                    'startAt' => $startAt,
                    'maxResults' => $maxResults,
                ],
            ]
        );

        $result = $this->deserialize($response, CommentSearchResult::class);
        if (!$result instanceof CommentSearchResult) {
            $result = new CommentSearchResult();
        }

        return $result;
    }

    public function findById(string $issueKey, string $id): ?Comment
    {
        $response = $this->client->get(sprintf('issue/%s/comment/%s', $issueKey, $id));

        $result = $this->deserialize($response, Comment::class);
        if (!$result instanceof Comment) {
            return null;
        }

        return $result;
    }

    /**
     * @throws CommentBodyEmptyException
     */
    public function add(string $issueKey, Comment $comment): ?Comment
    {
        if (null === $comment->getBody()) {
            throw new CommentBodyEmptyException();
        }

        $payload = $this->serialize($comment, ['groups' => Comment::WRITE_GROUP]);

        $response = $this->client->post(sprintf('issue/%s/comment', $issueKey), $payload);
        $result = $this->deserialize($response, Comment::class);
        if (!$result instanceof Comment) {
            return null;
        }

        return $result;
    }
}
