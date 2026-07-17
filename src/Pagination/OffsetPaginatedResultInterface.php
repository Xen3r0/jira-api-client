<?php

namespace Xen3r0\JiraApiClient\Pagination;

/**
 * @codeCoverageIgnore
 */
interface OffsetPaginatedResultInterface
{
    public function getStartAt(): int;

    public function getTotal(): int;
}
