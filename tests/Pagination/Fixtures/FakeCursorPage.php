<?php

namespace Xen3r0\JiraApiClient\Tests\Pagination\Fixtures;

use Xen3r0\JiraApiClient\Pagination\CursorPaginatedResultInterface;

class FakeCursorPage implements CursorPaginatedResultInterface
{
    /**
     * @param array<int, string> $items
     */
    public function __construct(
        private readonly bool $isLast,
        private readonly ?string $nextPageToken,
        private readonly array $items,
    ) {
    }

    public function getIsLast(): bool
    {
        return $this->isLast;
    }

    public function getNextPageToken(): ?string
    {
        return $this->nextPageToken;
    }

    /**
     * @return array<int, string>
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
