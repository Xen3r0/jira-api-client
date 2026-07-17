<?php

namespace Xen3r0\JiraApiClient\Tests\Pagination;

use PHPUnit\Framework\TestCase;
use Xen3r0\JiraApiClient\Pagination\Paginator;
use Xen3r0\JiraApiClient\Tests\Pagination\Fixtures\FakeCursorPage;
use Xen3r0\JiraApiClient\Tests\Pagination\Fixtures\FakeOffsetPage;

class PaginatorTest extends TestCase
{
    public function testByOffsetIteratesOverAllPages(): void
    {
        $pages = [
            0 => new FakeOffsetPage(0, 5, ['A', 'B']),
            2 => new FakeOffsetPage(2, 5, ['C', 'D']),
            4 => new FakeOffsetPage(4, 5, ['E']),
        ];

        $items = iterator_to_array(Paginator::byOffset(
            static fn (int $startAt): FakeOffsetPage => $pages[$startAt],
            static fn (FakeOffsetPage $page): array => $page->getItems(),
        ));

        $this->assertSame(['A', 'B', 'C', 'D', 'E'], array_values($items));
    }

    public function testByOffsetStopsOnEmptyPageEvenIfTotalNotReached(): void
    {
        $callCount = 0;
        $fetchPage = function (int $startAt) use (&$callCount): FakeOffsetPage {
            ++$callCount;

            return new FakeOffsetPage($startAt, 100, []);
        };

        $items = iterator_to_array(Paginator::byOffset(
            $fetchPage,
            static fn (FakeOffsetPage $page): array => $page->getItems(),
        ));

        $this->assertSame([], $items);
        $this->assertSame(1, $callCount);
    }

    public function testByCursorIteratesUntilIsLast(): void
    {
        $pages = [
            null => new FakeCursorPage(false, 'page-2', ['A', 'B']),
            'page-2' => new FakeCursorPage(true, null, ['C']),
        ];

        $items = iterator_to_array(Paginator::byCursor(
            static fn (?string $pageToken): FakeCursorPage => $pages[$pageToken],
            static fn (FakeCursorPage $page): array => $page->getItems(),
        ));

        $this->assertSame(['A', 'B', 'C'], array_values($items));
    }
}
