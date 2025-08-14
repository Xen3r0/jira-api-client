<?php

namespace Xen3r0\JiraApiClient\Model\Issue;

use DH\Adf\Node\Block\Document;
use Symfony\Component\Serializer\Attribute\Groups;
use Xen3r0\JiraApiClient\Model\User\User;

class Comment
{
    public const WRITE_GROUP = 'JAC:Issue:Comment:Write';

    private ?string $id = null;

    private ?User $author = null;

    private ?\DateTimeImmutable $created = null;

    private ?User $updateAuthor = null;

    private ?\DateTimeImmutable $updated = null;

    #[Groups(groups: [self::WRITE_GROUP])]
    private ?Document $body = null;

    private ?string $renderedBody = null;

    private bool $jsdAuthorCanSeeRequest = false;

    private bool $jsdPublic = false;

    /**
     * @var array<string, mixed>
     */
    #[Groups(groups: [self::WRITE_GROUP])]
    private array $properties = [];

    #[Groups(groups: [self::WRITE_GROUP])]
    private ?Visiblity $visiblity = null;

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

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): static
    {
        $this->author = $author;

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

    public function getUpdateAuthor(): ?User
    {
        return $this->updateAuthor;
    }

    public function setUpdateAuthor(?User $updateAuthor): static
    {
        $this->updateAuthor = $updateAuthor;

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

    public function getBody(): ?Document
    {
        return $this->body;
    }

    public function setBody(?Document $body): static
    {
        $this->body = $body;

        return $this;
    }

    public function getRenderedBody(): ?string
    {
        return $this->renderedBody;
    }

    public function setRenderedBody(?string $renderedBody): static
    {
        $this->renderedBody = $renderedBody;

        return $this;
    }

    public function isJsdAuthorCanSeeRequest(): bool
    {
        return $this->jsdAuthorCanSeeRequest;
    }

    public function setJsdAuthorCanSeeRequest(bool $jsdAuthorCanSeeRequest): static
    {
        $this->jsdAuthorCanSeeRequest = $jsdAuthorCanSeeRequest;

        return $this;
    }

    public function isJsdPublic(): bool
    {
        return $this->jsdPublic;
    }

    public function setJsdPublic(bool $jsdPublic): static
    {
        $this->jsdPublic = $jsdPublic;

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * @param array<string, mixed> $properties
     */
    public function setProperties(array $properties): static
    {
        $this->properties = $properties;

        return $this;
    }

    public function getVisiblity(): ?Visiblity
    {
        return $this->visiblity;
    }

    public function setVisiblity(?Visiblity $visiblity): static
    {
        $this->visiblity = $visiblity;

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
