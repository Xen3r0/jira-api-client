<?php

namespace Xen3r0\JiraApiClient\Repository\Issue;

use Xen3r0\JiraApiClient\Model\Issue\TransitionSearchResult;
use Xen3r0\JiraApiClient\Repository\AbstractRepository;

readonly class IssueTransitionRepository extends AbstractRepository implements IssueTransitionRepositoryInterface
{
    public function findAll(string $issueIdOrKey): TransitionSearchResult
    {
        $response = $this->client->get(sprintf('issue/%s/transitions', $issueIdOrKey));

        $result = $this->deserialize($response, TransitionSearchResult::class);
        if (!$result instanceof TransitionSearchResult) {
            $result = new TransitionSearchResult();
        }

        return $result;
    }

    public function transition(string $issueIdOrKey, string $transitionId): void
    {
        $this->client->post(
            sprintf('issue/%s/transitions', $issueIdOrKey),
            [
                'transition' => [
                    'id' => $transitionId,
                ],
            ]
        );
    }
}
