<?php

namespace Xen3r0\JiraApiClient\Model\Issue;

use Xen3r0\JiraApiClient\Model\User\User;

class Votes
{
    private bool $hasVoted = false;

    private int $votes = 0;

    /**
     * @var array<int, User>
     */
    private array $voters = [];

    private ?string $self = null;

    public function isHasVoted(): bool
    {
        return $this->hasVoted;
    }

    public function setHasVoted(bool $hasVoted): static
    {
        $this->hasVoted = $hasVoted;

        return $this;
    }

    public function getVotes(): int
    {
        return $this->votes;
    }

    public function setVotes(int $votes): static
    {
        $this->votes = $votes;

        return $this;
    }

    /**
     * @return array<int, User>
     */
    public function getVoters(): array
    {
        return $this->voters;
    }

    /**
     * @param array<int, User> $voters
     */
    public function setVoters(array $voters): static
    {
        $this->voters = $voters;

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
