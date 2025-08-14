<?php

namespace Xen3r0\JiraApiClient\Repository\Project;

use Xen3r0\JiraApiClient\Model\Project\Project;
use Xen3r0\JiraApiClient\Model\Project\ProjectSearchResult;
use Xen3r0\JiraApiClient\Repository\AbstractRepository;

class ProjectRepository extends AbstractRepository implements ProjectRepositoryInterface
{
    public function findAll(string $query, int $maxResults = 50, int $startAt = 0, string $orderBy = 'name'): ProjectSearchResult
    {
        $response = $this->client->get(
            'project/search',
            [
                'query' => [
                    'query' => $query,
                    'startAt' => $startAt,
                    'maxResults' => $maxResults,
                    'orderBy' => $orderBy,
                    'fields' => [],
                    'expand' => '',
                ],
            ]
        );

        $result = $this->deserialize($response, ProjectSearchResult::class);
        if (!$result instanceof ProjectSearchResult) {
            $result = new ProjectSearchResult();
        }

        return $result;
    }

    public function findByIdOrKey(string $id): ?Project
    {
        $response = $this->client->get(sprintf('project/%s', $id));

        $result = $this->deserialize($response, Project::class);
        if (!$result instanceof Project) {
            return null;
        }

        return $result;
    }
}
