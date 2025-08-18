<?php

namespace Xen3r0\JiraApiClient\Repository\Project;

use Xen3r0\JiraApiClient\Model\Version\Version;

interface VersionRepositoryInterface
{
    public function findById(string $id): ?Version;

    public function add(Version $version): ?Version;

    public function update(Version $version): ?Version;

    public function remove(string $id): void;
}
