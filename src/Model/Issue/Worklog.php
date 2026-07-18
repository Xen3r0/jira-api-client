<?php

namespace Xen3r0\JiraApiClient\Model\Issue;

use Symfony\Component\Serializer\Attribute\Groups;
use Xen3r0\Adf\Node\Block\Document;
use Xen3r0\JiraApiClient\Model\User\User;

class Worklog
{
    public const WRITE_GROUP = 'JAC:Issue:Worklog:Write';

    private ?string $id = null;

    private ?string $self = null;

    private ?string $issueId = null;

    private ?User $author = null;

    private ?User $updateAuthor = null;

    #[Groups(groups: [self::WRITE_GROUP])]
    private ?Document $comment = null;

    private ?\DateTimeImmutable $created = null;

    private ?\DateTimeImmutable $updated = null;

    #[Groups(groups: [self::WRITE_GROUP])]
    private ?\DateTimeImmutable $started = null;

    #[Groups(groups: [self::WRITE_GROUP])]
    private ?string $timeSpent = null;

    #[Groups(groups: [self::WRITE_GROUP])]
    private ?int $timeSpentSeconds = null;

    #[Groups(groups: [self::WRITE_GROUP])]
    private ?Visiblity $visibility = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): static
    {
        $this->id = $id;

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

    public function getIssueId(): ?string
    {
        return $this->issueId;
    }

    public function setIssueId(?string $issueId): static
    {
        $this->issueId = $issueId;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getUpdateAuthor(): ?User
    {
        return $this->updateAuthor;
    }

    public function setUpdateAuthor(?User $updateAuthor): static
    {
        $this->updateAuthor = $updateAuthor;

        return $this;
    }

    public function getComment(): ?Document
    {
        return $this->comment;
    }

    public function setComment(?Document $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    public function getCreated(): ?\DateTimeImmutable
    {
        return $this->created;
    }

    public function setCreated(?\DateTimeImmutable $created): static
    {
        $this->created = $created;

        return $this;
    }

    public function getUpdated(): ?\DateTimeImmutable
    {
        return $this->updated;
    }

    public function setUpdated(?\DateTimeImmutable $updated): static
    {
        $this->updated = $updated;

        return $this;
    }

    public function getStarted(): ?\DateTimeImmutable
    {
        return $this->started;
    }

    public function setStarted(?\DateTimeImmutable $started): static
    {
        $this->started = $started;

        return $this;
    }

    public function getTimeSpent(): ?string
    {
        return $this->timeSpent;
    }

    public function setTimeSpent(?string $timeSpent): static
    {
        $this->timeSpent = $timeSpent;

        return $this;
    }

    public function getTimeSpentSeconds(): ?int
    {
        return $this->timeSpentSeconds;
    }

    public function setTimeSpentSeconds(?int $timeSpentSeconds): static
    {
        $this->timeSpentSeconds = $timeSpentSeconds;

        return $this;
    }

    public function getVisibility(): ?Visiblity
    {
        return $this->visibility;
    }

    public function setVisibility(?Visiblity $visibility): static
    {
        $this->visibility = $visibility;

        return $this;
    }
}
