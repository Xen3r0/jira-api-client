<?php

namespace Xen3r0\JiraApiClient\Model\Issue;

use Xen3r0\JiraApiClient\Pagination\OffsetPaginatedResultInterface;

class WorklogSearchResult implements OffsetPaginatedResultInterface
{
    private int $maxResults = 50;

    private int $startAt = 0;

    private int $total = 0;

    /**
     * @var array<int, Worklog>
     */
    private array $worklogs = [];

    public function getMaxResults(): int
    {
        return $this->maxResults;
    }

    public function setMaxResults(int $maxResults): static
    {
        $this->maxResults = $maxResults;

        return $this;
    }

    public function getStartAt(): int
    {
        return $this->startAt;
    }

    public function setStartAt(int $startAt): static
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function setTotal(int $total): static
    {
        $this->total = $total;

        return $this;
    }

    /**
     * @return array<int, Worklog>
     */
    public function getWorklogs(): array
    {
        return $this->worklogs;
    }

    /**
     * @param array<int, Worklog> $worklogs
     */
    public function setWorklogs(array $worklogs): static
    {
        $this->worklogs = $worklogs;

        return $this;
    }
}
