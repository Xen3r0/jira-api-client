<?php

namespace Xen3r0\JiraApiClient\Repository\Project;

use Xen3r0\JiraApiClient\Model\Project\Component;

/**
 * @codeCoverageIgnore
 */
interface ComponentRepositoryInterface
{
    public function findById(string $id): ?Component;

    public function add(Component $component): ?Component;

    public function update(Component $component): ?Component;

    public function remove(string $id): void;
}
