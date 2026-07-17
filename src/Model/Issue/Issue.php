<?php

namespace Xen3r0\JiraApiClient\Model\Issue;

use Symfony\Component\Serializer\Attribute\Groups;

class Issue
{
    public ?string $expand = null;

    public ?string $id = null;

    public ?string $self = null;

    #[Groups(groups: [Link::WRITE_GROUP])]
    public ?string $key = null;

    #[Groups(groups: [Fields::WRITE_GROUP])]
    public Fields $fields;

    public function __construct()
    {
        $this->fields = new Fields();
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

    public function getKey(): ?string
    {
        return $this->key;
    }

    public function setKey(?string $key): static
    {
        $this->key = $key;

        return $this;
    }

    public function getFields(): Fields
    {
        return $this->fields;
    }

    public function setFields(Fields $fields): static
    {
        $this->fields = $fields;

        return $this;
    }
}
