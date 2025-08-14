<?php

namespace Xen3r0\JiraApiClient\Model\Issue;

class LinkType
{
    private ?string $id = null;

    private ?string $name = null;

    private ?string $inward = null;

    private ?string $outward = null;

    private ?string $self = null;

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

    public function getInward(): ?string
    {
        return $this->inward;
    }

    public function setInward(?string $inward): static
    {
        $this->inward = $inward;

        return $this;
    }

    public function getOutward(): ?string
    {
        return $this->outward;
    }

    public function setOutward(?string $outward): static
    {
        $this->outward = $outward;

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
