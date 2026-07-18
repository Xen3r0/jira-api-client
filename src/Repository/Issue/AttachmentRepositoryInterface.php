<?php

namespace Xen3r0\JiraApiClient\Repository\Issue;

use Xen3r0\JiraApiClient\Model\Issue\Attachment;

/**
 * @codeCoverageIgnore
 */
interface AttachmentRepositoryInterface
{
    /**
     * @return array<int, Attachment>
     */
    public function add(string $issueIdOrKey, string $filePath): array;

    public function findById(string $id): ?Attachment;

    public function remove(string $id): void;

    public function getContent(string $id): string;
}
