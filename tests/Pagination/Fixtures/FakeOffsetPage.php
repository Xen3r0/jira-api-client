<?php

namespace Xen3r0\JiraApiClient\Tests\Pagination\Fixtures;

use Xen3r0\JiraApiClient\Pagination\OffsetPaginatedResultInterface;

class FakeOffsetPage implements OffsetPaginatedResultInterface
{
    /**
     * @param array<int, string> $items
     */
    public function __construct(
        private readonly int $startAt,
        private readonly int $total,
        private readonly array $items,
    ) {
    }

    public function getStartAt(): int
    {
        return $this->startAt;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @return array<int, string>
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
