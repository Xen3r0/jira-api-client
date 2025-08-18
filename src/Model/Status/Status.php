<?php

namespace Xen3r0\JiraApiClient\Model\Status;

use Xen3r0\JiraApiClient\Model\Workflow\StatusCategory;

class Status
{
    private ?string $id = null;

    private ?string $name = null;

    private ?string $description = null;

    private ?string $self = null;

    private ?StatusCategory $statusCategory = null;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

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

    public function getStatusCategory(): ?StatusCategory
    {
        return $this->statusCategory;
    }

    public function setStatusCategory(?StatusCategory $statusCategory): static
    {
        $this->statusCategory = $statusCategory;

        return $this;
    }
}
