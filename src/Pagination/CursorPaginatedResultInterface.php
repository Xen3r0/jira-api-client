<?php

namespace Xen3r0\JiraApiClient\Pagination;

/**
 * @codeCoverageIgnore
 */
interface CursorPaginatedResultInterface
{
    public function getIsLast(): bool;

    public function getNextPageToken(): ?string;
}
