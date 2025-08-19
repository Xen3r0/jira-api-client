<?php

namespace Xen3r0\JiraApiClient\Repository\Issue;

use Xen3r0\JiraApiClient\Model\Issue\Issue;
use Xen3r0\JiraApiClient\Model\Issue\IssueSearchResult;
use Xen3r0\JiraApiClient\Repository\AbstractRepository;

class IssueRepository extends AbstractRepository implements IssueRepositoryInterface
{
    public function findAll(string $jql, int $maxResults = 15, ?string $nextPageToken = null): IssueSearchResult
    {
        $response = $this->client->post(
            'search/jql',
            [
                'jql' => $jql,
                'maxResults' => $maxResults,
                'fields' => [],
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
}
