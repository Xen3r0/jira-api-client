<?php

namespace Xen3r0\JiraApiClient\Model\Issue;

use Xen3r0\JiraApiClient\Model\Status\Status;

class Transition
{
    private ?string $id = null;

    private ?string $name = null;

    private ?Status $to = null;

    private bool $hasScreen = false;

    private bool $isAvailable = true;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getTo(): ?Status
    {
        return $this->to;
    }

    public function setTo(?Status $to): static
    {
        $this->to = $to;

        return $this;
    }

    public function getHasScreen(): bool
    {
        return $this->hasScreen;
    }

    public function setHasScreen(bool $hasScreen): static
    {
        $this->hasScreen = $hasScreen;

        return $this;
    }

    public function getIsAvailable(): bool
    {
        return $this->isAvailable;
    }

    public function setIsAvailable(bool $isAvailable): static
    {
        $this->isAvailable = $isAvailable;

        return $this;
    }
}
