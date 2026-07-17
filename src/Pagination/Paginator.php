<?php

namespace Xen3r0\JiraApiClient\Pagination;

class Paginator
{
    /**
     * @template T
     * @template P of OffsetPaginatedResultInterface
     *
     * @param callable(int): P           $fetchPage
     * @param callable(P): array<int, T> $extractItems
     *
     * @return iterable<int, T>
     */
    public static function byOffset(callable $fetchPage, callable $extractItems, int $startAt = 0): iterable
    {
        do {
            $page = $fetchPage($startAt);
            $items = $extractItems($page);

            foreach ($items as $item) {
                yield $item;
            }

            $startAt += count($items);
        } while ([] !== $items && $startAt < $page->getTotal());
    }

    /**
     * @template T
     * @template P of CursorPaginatedResultInterface
     *
     * @param callable(?string): P       $fetchPage
     * @param callable(P): array<int, T> $extractItems
     *
     * @return iterable<int, T>
     */
    public static function byCursor(callable $fetchPage, callable $extractItems): iterable
    {
        $pageToken = null;

        do {
            $page = $fetchPage($pageToken);
            $items = $extractItems($page);

            foreach ($items as $item) {
                yield $item;
            }

            $pageToken = $page->getNextPageToken();
        } while (!$page->getIsLast() && null !== $pageToken);
    }
}
