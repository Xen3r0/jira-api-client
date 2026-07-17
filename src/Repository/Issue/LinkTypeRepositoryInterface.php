<?php

namespace Xen3r0\JiraApiClient\Repository\Issue;

use Xen3r0\JiraApiClient\Model\Issue\LinkType;

/**
 * @codeCoverageIgnore
 */
interface LinkTypeRepositoryInterface
{
    /**
     * @return array<int, LinkType>
     */
    public function findAll(): array;

    public function findById(string $id): ?LinkType;
}
