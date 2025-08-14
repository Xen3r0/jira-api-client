<?php

namespace Xen3r0\JiraApiClient\Model\Project;

use Xen3r0\JiraApiClient\Model\User\User;

class Component
{
    private ?string $ari = null;

    private ?User $assignee = null;

    private ?string $assigneeType = null;

    private ?string $description = null;

    private ?string $id = null;

    private bool $isAssigneeTypeValid = false;

    private ?User $lead = null;

    /**
     * @var array<string, string>
     */
    private array $metadata = [];

    private ?string $name = null;

    private ?string $project = null;

    private ?int $projectId = null;

    private ?User $realAssignee = null;

    private ?string $realAssigneeType = null;

    private ?string $self = null;

    public function getAri(): ?string
    {
        return $this->ari;
    }

    public function setAri(?string $ari): static
    {
        $this->ari = $ari;

        return $this;
    }

    public function getAssignee(): ?User
    {
        return $this->assignee;
    }

    public function setAssignee(?User $assignee): static
    {
        $this->assignee = $assignee;

        return $this;
    }

    public function getAssigneeType(): ?string
    {
        return $this->assigneeType;
    }

    public function setAssigneeType(?string $assigneeType): static
    {
        $this->assigneeType = $assigneeType;

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

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function isAssigneeTypeValid(): bool
    {
        return $this->isAssigneeTypeValid;
    }

    public function setIsAssigneeTypeValid(bool $isAssigneeTypeValid): static
    {
        $this->isAssigneeTypeValid = $isAssigneeTypeValid;

        return $this;
    }

    public function getLead(): ?User
    {
        return $this->lead;
    }

    public function setLead(?User $lead): static
    {
        $this->lead = $lead;

        return $this;
    }

    /**
     * @return array<string, string>
     */
    public function getMetadata(): array
    {
        return $this->metadata;
    }

    /**
     * @param array<string, string> $metadata
     */
    public function setMetadata(array $metadata): static
    {
        $this->metadata = $metadata;

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

    public function getProject(): ?string
    {
        return $this->project;
    }

    public function setProject(?string $project): static
    {
        $this->project = $project;

        return $this;
    }

    public function getProjectId(): ?int
    {
        return $this->projectId;
    }

    public function setProjectId(?int $projectId): static
    {
        $this->projectId = $projectId;

        return $this;
    }

    public function getRealAssignee(): ?User
    {
        return $this->realAssignee;
    }

    public function setRealAssignee(?User $realAssignee): static
    {
        $this->realAssignee = $realAssignee;

        return $this;
    }

    public function getRealAssigneeType(): ?string
    {
        return $this->realAssigneeType;
    }

    public function setRealAssigneeType(?string $realAssigneeType): static
    {
        $this->realAssigneeType = $realAssigneeType;

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
