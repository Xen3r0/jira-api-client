<?php

namespace Xen3r0\JiraApiClient\Model\Issue;

class CommentSearchResult
{
    private int $maxResults = 100;

    private int $startAt = 0;

    private int $total = 0;

    /**
     * @var array<int, Comment>
     */
    private array $comments = [];

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
     * @return array<int, Comment>
     */
    public function getComments(): array
    {
        return $this->comments;
    }

    /**
     * @param array<int, Comment> $comments
     */
    public function setComments(array $comments): static
    {
        $this->comments = $comments;

        return $this;
    }
}
