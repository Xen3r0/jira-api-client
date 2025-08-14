<?php

namespace Xen3r0\JiraApiClient\Model\Version;

use Symfony\Component\Serializer\Attribute\Groups;

class Version
{
    public const WRITE_GROUP = 'JAC:Project:Version:Write';

    #[Groups(groups: [self::WRITE_GROUP])]
    private ?string $id = null;

    #[Groups(groups: [self::WRITE_GROUP])]
    private ?int $projectId = null;

    #[Groups(groups: [self::WRITE_GROUP])]
    private ?string $name = null;

    #[Groups(groups: [self::WRITE_GROUP])]
    private ?string $description = null;

    private ?string $self = null;

    #[Groups(groups: [self::WRITE_GROUP])]
    private bool $archived = false;

    #[Groups(groups: [self::WRITE_GROUP])]
    private ?\DateTimeImmutable $startDate = null;

    private ?string $userStartDate = null;

    #[Groups(groups: [self::WRITE_GROUP])]
    private bool $released = false;

    #[Groups(groups: [self::WRITE_GROUP])]
    private ?\DateTimeImmutable $releaseDate = null;

    private ?string $userReleaseDate = null;

    private bool $overdue = false;

    #[Groups(groups: [self::WRITE_GROUP])]
    private ?string $expand = null;

    #[Groups(groups: [self::WRITE_GROUP])]
    private ?string $moveUnfixedIssuesTo = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): static
    {
        $this->id = $id;

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

    public function isArchived(): bool
    {
        return $this->archived;
    }

    public function setArchived(bool $archived): static
    {
        $this->archived = $archived;

        return $this;
    }

    public function getStartDate(): ?\DateTimeImmutable
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeImmutable $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getUserStartDate(): ?string
    {
        return $this->userStartDate;
    }

    public function setUserStartDate(?string $userStartDate): static
    {
        $this->userStartDate = $userStartDate;

        return $this;
    }

    public function gsReleased(): bool
    {
        return $this->released;
    }

    public function setReleased(bool $released): static
    {
        $this->released = $released;

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeImmutable
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(?\DateTimeImmutable $releaseDate): static
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    public function getUserReleaseDate(): ?string
    {
        return $this->userReleaseDate;
    }

    public function setUserReleaseDate(?string $userReleaseDate): static
    {
        $this->userReleaseDate = $userReleaseDate;

        return $this;
    }

    public function getOverdue(): bool
    {
        return $this->overdue;
    }

    public function setOverdue(bool $overdue): static
    {
        $this->overdue = $overdue;

        return $this;
    }

    public function getExpand(): ?string
    {
        return $this->expand;
    }

    public function setExpand(?string $expand): static
    {
        $this->expand = $expand;

        return $this;
    }

    public function getMoveUnfixedIssuesTo(): ?string
    {
        return $this->moveUnfixedIssuesTo;
    }

    public function setMoveUnfixedIssuesTo(?string $moveUnfixedIssuesTo): static
    {
        $this->moveUnfixedIssuesTo = $moveUnfixedIssuesTo;

        return $this;
    }
}
