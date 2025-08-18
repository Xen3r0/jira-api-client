<?php

namespace Xen3r0\JiraApiClient\Model\Issue;

class Type
{
    private ?string $id = null;

    private ?string $name = null;

    private ?string $description = null;

    private ?int $avatarId = null;

    private ?int $hierarchyLevel = null;

    private ?string $iconUrl = null;

    private ?bool $subtask = null;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getAvatarId(): ?int
    {
        return $this->avatarId;
    }

    public function setAvatarId(?int $avatarId): static
    {
        $this->avatarId = $avatarId;

        return $this;
    }

    public function getHierarchyLevel(): ?int
    {
        return $this->hierarchyLevel;
    }

    public function setHierarchyLevel(?int $hierarchyLevel): static
    {
        $this->hierarchyLevel = $hierarchyLevel;

        return $this;
    }

    public function getIconUrl(): ?string
    {
        return $this->iconUrl;
    }

    public function setIconUrl(?string $iconUrl): static
    {
        $this->iconUrl = $iconUrl;

        return $this;
    }

    public function getSubtask(): ?bool
    {
        return $this->subtask;
    }

    public function setSubtask(?bool $subtask): static
    {
        $this->subtask = $subtask;

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
