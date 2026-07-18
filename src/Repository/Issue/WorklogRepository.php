<?php

namespace Xen3r0\JiraApiClient\Repository\Issue;

use Xen3r0\JiraApiClient\Exception\Issue\WorklogMustBeExistsException;
use Xen3r0\JiraApiClient\Model\Issue\Worklog;
use Xen3r0\JiraApiClient\Model\Issue\WorklogSearchResult;
use Xen3r0\JiraApiClient\Repository\AbstractRepository;

readonly class WorklogRepository extends AbstractRepository implements WorklogRepositoryInterface
{
    public function findAll(string $issueIdOrKey, int $startAt = 0, int $maxResults = 50): WorklogSearchResult
    {
        $response = $this->client->get(
            sprintf('issue/%s/worklog', $issueIdOrKey),
            [
                'query' => [
                    'startAt' => $startAt,
                    'maxResults' => $maxResults,
                ],
            ]
        );

        $result = $this->deserialize($response, WorklogSearchResult::class);
        if (!$result instanceof WorklogSearchResult) {
            $result = new WorklogSearchResult();
        }

        return $result;
    }

    public function findById(string $issueIdOrKey, string $id): ?Worklog
    {
        $response = $this->client->get(sprintf('issue/%s/worklog/%s', $issueIdOrKey, $id));

        $result = $this->deserialize($response, Worklog::class);
        if (!$result instanceof Worklog) {
            return null;
        }

        return $result;
    }

    public function add(string $issueIdOrKey, Worklog $worklog): ?Worklog
    {
        $payload = $this->serialize($worklog, ['groups' => Worklog::WRITE_GROUP]);

        $response = $this->client->post(sprintf('issue/%s/worklog', $issueIdOrKey), $payload);
        $result = $this->deserialize($response, Worklog::class);
        if (!$result instanceof Worklog) {
            return null;
        }

        return $result;
    }

    /**
     * @throws WorklogMustBeExistsException
     */
    public function update(string $issueIdOrKey, Worklog $worklog): ?Worklog
    {
        if (!$worklog->getId()) {
            throw new WorklogMustBeExistsException();
        }

        $payload = $this->serialize($worklog, ['groups' => Worklog::WRITE_GROUP]);

        $response = $this->client->put(sprintf('issue/%s/worklog/%s', $issueIdOrKey, $worklog->getId()), $payload);
        $result = $this->deserialize($response, Worklog::class);
        if (!$result instanceof Worklog) {
            return null;
        }

        return $result;
    }

    public function remove(string $issueIdOrKey, string $id): void
    {
        $this->client->delete(sprintf('issue/%s/worklog/%s', $issueIdOrKey, $id));
    }
}
