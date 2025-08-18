<?php

namespace Xen3r0\JiraApiClient\Model\Issue;

class CustomField
{
    private ?string $id = null;

    private ?string $value = null;

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

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): static
    {
        $this->value = $value;

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
