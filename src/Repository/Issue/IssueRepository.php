<?php

namespace Xen3r0\JiraApiClient\Repository\Issue;

use Xen3r0\JiraApiClient\Exception\Issue\IssueMustBeExistsException;
use Xen3r0\JiraApiClient\Model\Issue\Fields;
use Xen3r0\JiraApiClient\Model\Issue\Issue;
use Xen3r0\JiraApiClient\Model\Issue\IssueSearchResult;
use Xen3r0\JiraApiClient\Repository\AbstractRepository;

readonly class IssueRepository extends AbstractRepository implements IssueRepositoryInterface
{
    /**
     * @param array<int, string> $fields
     */
    public function findAll(string $jql, int $maxResults = 15, ?string $nextPageToken = null, array $fields = ['*all']): IssueSearchResult
    {
        $response = $this->client->post(
            'search/jql',
            [
                'jql' => $jql,
                'maxResults' => $maxResults,
                'fields' => $fields,
                'expand' => '',
                'nextPageToken' => $nextPageToken,
            ]
        );

        $result = $this->deserialize($response, IssueSearchResult::class);
        if (!$result instanceof IssueSearchResult) {
            $result = new IssueSearchResult();
        }

        return $result;
    }

    public function findByIdOrKey(string $id): ?Issue
    {
        $response = $this->client->get(sprintf('issue/%s', $id));

        $result = $this->deserialize($response, Issue::class);
        if (!$result instanceof Issue) {
            return null;
        }

        return $result;
    }

    public function create(Issue $issue): ?Issue
    {
        $payload = $this->serialize($issue, ['groups' => Fields::WRITE_GROUP]);

        $response = $this->client->post('issue', $payload);
        $result = $this->deserialize($response, Issue::class);
        if (!$result instanceof Issue) {
            return null;
        }

        return $result;
    }

    /**
     * @throws IssueMustBeExistsException
     */
    public function update(Issue $issue): void
    {
        if (!$issue->key && !$issue->id) {
            throw new IssueMustBeExistsException();
        }

        $payload = $this->serialize($issue, ['groups' => Fields::WRITE_GROUP]);

        $this->client->put(sprintf('issue/%s', $issue->key ?? $issue->id), $payload);
    }

    public function delete(string $idOrKey): void
    {
        $this->client->delete(sprintf('issue/%s', $idOrKey));
    }
}
