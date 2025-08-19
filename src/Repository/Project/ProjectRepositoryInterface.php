<?php

namespace Xen3r0\JiraApiClient\Repository\Project;

use Xen3r0\JiraApiClient\Model\Project\Project;
use Xen3r0\JiraApiClient\Model\Project\ProjectSearchResult;

interface ProjectRepositoryInterface
{
    public function findAll(?string $query = null, int $maxResults = 50, int $startAt = 0, string $orderBy = 'name'): ProjectSearchResult;

    public function findByIdOrKey(string $id): ?Project;
}
