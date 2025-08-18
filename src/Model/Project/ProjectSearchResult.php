<?php

namespace Xen3r0\JiraApiClient\Model\Project;

class ProjectSearchResult
{
    private bool $isLast = false;

    private int $startAt = 0;

    private int $maxResults = 50;

    private int $total = 0;

    private ?string $nextPage = null;

    /**
     * @var array<int, Project>
     */
    private array $values = [];

    private ?string $self = null;

    public function getIsLast(): bool
    {
        return $this->isLast;
    }

    public function setIsLast(bool $isLast): static
    {
        $this->isLast = $isLast;

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

    public function getMaxResults(): int
    {
        return $this->maxResults;
    }

    public function setMaxResults(int $maxResults): static
    {
        $this->maxResults = $maxResults;

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

    public function getNextPage(): ?string
    {
        return $this->nextPage;
    }

    public function setNextPage(?string $nextPage): static
    {
        $this->nextPage = $nextPage;

        return $this;
    }

    /**
     * @return array<int, Project>
     */
    public function getValues(): array
    {
        return $this->values;
    }

    /**
     * @param array<int, Project> $values
     */
    public function setValues(array $values): static
    {
        $this->values = $values;

        return $this;
    }

    public function getSelf(): ?string
    {
        return $this->self;
    }

    public function setSelf(?string $self): static
    {
        $this->self = $self;

        return $this;
    }
}
