<?php

namespace Xen3r0\JiraApiClient\Model\Issue;

use Symfony\Component\Serializer\Attribute\Groups;

class CustomFieldOption
{
    public const WRITE_GROUP = 'JAC:Issue:CustomFieldOption:Write';

    #[Groups(groups: [self::WRITE_GROUP])]
    private ?string $id = null;

    #[Groups(groups: [self::WRITE_GROUP])]
    private ?string $value = null;

    #[Groups(groups: [self::WRITE_GROUP])]
    private bool $disabled = false;

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

    public function getDisabled(): bool
    {
        return $this->disabled;
    }

    public function setDisabled(bool $disabled): static
    {
        $this->disabled = $disabled;

        return $this;
    }
}
