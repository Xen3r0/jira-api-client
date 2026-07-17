<?php

namespace Xen3r0\JiraApiClient\Repository\Issue;

use Xen3r0\JiraApiClient\Model\Issue\Link;

/**
 * @codeCoverageIgnore
 */
interface IssueLinkRepositoryInterface
{
    public function add(Link $link): void;

    public function findById(string $linkId): ?Link;

    public function remove(string $linkId): void;
}
