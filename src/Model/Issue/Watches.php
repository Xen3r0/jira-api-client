<?php

namespace Xen3r0\JiraApiClient\Model\Issue;

class Watches
{
    private bool $isWatching = false;

    private int $watchCount = 0;

    private ?string $self = null;

    public function isWatching(): bool
    {
        return $this->isWatching;
    }

    public function setIsWatching(bool $isWatching): static
    {
        $this->isWatching = $isWatching;

        return $this;
    }

    public function getWatchCount(): int
    {
        return $this->watchCount;
    }

    public function setWatchCount(int $watchCount): static
    {
        $this->watchCount = $watchCount;

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
