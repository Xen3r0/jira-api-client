<?php

namespace Xen3r0\JiraApiClient\Repository\Issue;

use Xen3r0\JiraApiClient\Model\Issue\CustomFieldContextOptionsList;
use Xen3r0\JiraApiClient\Model\Issue\CustomFieldOption;
use Xen3r0\JiraApiClient\Model\Issue\CustomFieldOptionSearchResult;

interface CustomFieldOptionRepositoryInterface
{
    public function findAll(string $fieldId, int $contextId, int $maxResults = 100, int $startAt = 0): CustomFieldOptionSearchResult;

    public function findById(string $optionId): ?CustomFieldOption;

    /**
     * @param array<int, CustomFieldOption> $options
     */
    public function add(string $fieldId, int $contextId, array $options): ?CustomFieldContextOptionsList;

    /**
     * @param array<int, CustomFieldOption> $options
     */
    public function update(string $fieldId, int $contextId, array $options): ?CustomFieldContextOptionsList;
}
