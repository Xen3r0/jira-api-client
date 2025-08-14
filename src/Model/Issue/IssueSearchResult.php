<?php

namespace Xen3r0\JiraApiClient\Model\Issue;

class IssueSearchResult
{
    /**
     * @var array<int, Issue>
     */
    private array $issues = [];

    private bool $isLast = false;

    private ?string $nextPageToken = null;

    /**
     * @return array<int, Issue>
     */
    public function getIssues(): array
    {
        return $this->issues;
    }

    /**
     * @param array<int, Issue> $issues
     */
    public function setIssues(array $issues): static
    {
        $this->issues = $issues;

        return $this;
    }

    public function getIsLast(): bool
    {
        return $this->isLast;
    }

    public function setIsLast(bool $isLast): static
    {
        $this->isLast = $isLast;

        return $this;
    }

    public function getNextPageToken(): ?string
    {
        return $this->nextPageToken;
    }

    public function setNextPageToken(?string $nextPageToken): static
    {
        $this->nextPageToken = $nextPageToken;

        return $this;
    }
}
