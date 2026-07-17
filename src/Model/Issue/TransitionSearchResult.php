<?php

namespace Xen3r0\JiraApiClient\Model\Issue;

class TransitionSearchResult
{
    private ?string $expand = null;

    /**
     * @var array<int, Transition>
     */
    private array $transitions = [];

    public function getExpand(): ?string
    {
        return $this->expand;
    }

    public function setExpand(?string $expand): static
    {
        $this->expand = $expand;

        return $this;
    }

    /**
     * @return array<int, Transition>
     */
    public function getTransitions(): array
    {
        return $this->transitions;
    }

    /**
     * @param array<int, Transition> $transitions
     */
    public function setTransitions(array $transitions): static
    {
        $this->transitions = $transitions;

        return $this;
    }
}
