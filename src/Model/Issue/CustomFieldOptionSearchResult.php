<?php

namespace Xen3r0\JiraApiClient\Model\Issue;

class CustomFieldOptionSearchResult
{
    private bool $isLast = false;

    private int $maxResults = 100;

    private int $startAt = 0;

    private int $total = 0;

    /**
     * @var array<int, CustomFieldOption>
     */
    private array $values = [];

    public function getIsLast(): bool
    {
        return $this->isLast;
    }

    public function setIsLast(bool $isLast): static
    {
        $this->isLast = $isLast;

        return $this;
    }

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
     * @return array<int, CustomFieldOption>
     */
    public function getValues(): array
    {
        return $this->values;
    }

    /**
     * @param array<int, CustomFieldOption> $values
     */
    public function setValues(array $values): static
    {
        $this->values = $values;

        return $this;
    }
}
