<?php

namespace Xen3r0\JiraApiClient\Repository\Issue;

use Xen3r0\JiraApiClient\Model\Issue\CustomFieldContextOptionsList;
use Xen3r0\JiraApiClient\Model\Issue\CustomFieldOption;
use Xen3r0\JiraApiClient\Model\Issue\CustomFieldOptionSearchResult;
use Xen3r0\JiraApiClient\Repository\AbstractRepository;

class CustomFieldOptionRepository extends AbstractRepository implements CustomFieldOptionRepositoryInterface
{
    public function findAll(string $fieldId, int $contextId, int $maxResults = 100, int $startAt = 0): CustomFieldOptionSearchResult
    {
        $response = $this->client->get(
            sprintf('field/%s/context/%d/option', $fieldId, $contextId),
            [
                'query' => [
                    'startAt' => $startAt,
                    'maxResults' => $maxResults,
                ],
            ]
        );

        $result = $this->deserialize($response, CustomFieldOptionSearchResult::class);
        if (!$result instanceof CustomFieldOptionSearchResult) {
            $result = new CustomFieldOptionSearchResult();
        }

        return $result;
    }

    public function findById(string $optionId): ?CustomFieldOption
    {
        $response = $this->client->get(sprintf('customFieldOption/%s', $optionId));

        $result = $this->deserialize($response, CustomFieldOption::class);
        if (!$result instanceof CustomFieldOption) {
            return null;
        }

        return $result;
    }

    /**
     * @param array<int, CustomFieldOption> $options
     */
    public function add(string $fieldId, int $contextId, array $options): ?CustomFieldContextOptionsList
    {
        $data = (new CustomFieldContextOptionsList())->setOptions($options);
        $payload = $this->serialize($data, ['groups' => CustomFieldOption::WRITE_GROUP]);

        $response = $this->client->post(
            sprintf('field/%s/context/%d/option', $fieldId, $contextId),
            $payload
        );
        $result = $this->deserialize($response, CustomFieldContextOptionsList::class);
        if (!$result instanceof CustomFieldContextOptionsList) {
            return null;
        }

        return $result;
    }

    /**
     * @param array<int, CustomFieldOption> $options
     */
    public function update(string $fieldId, int $contextId, array $options): ?CustomFieldContextOptionsList
    {
        $data = (new CustomFieldContextOptionsList())->setOptions($options);
        $payload = $this->serialize($data, ['groups' => CustomFieldOption::WRITE_GROUP]);

        $response = $this->client->put(
            sprintf('field/%s/context/%d/option', $fieldId, $contextId),
            $payload
        );
        $result = $this->deserialize($response, CustomFieldContextOptionsList::class);
        if (!$result instanceof CustomFieldContextOptionsList) {
            return null;
        }

        return $result;
    }
}
