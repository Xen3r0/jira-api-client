<?php

namespace Xen3r0\JiraApiClient\Model\User;

use Xen3r0\JiraApiClient\Enum\User\AccountType;
use Xen3r0\JiraApiClient\Model\Avatar\Urls;

class User
{
    private ?string $accountId = null;

    private ?AccountType $accountType = null;

    private bool $active = false;

    private ?Urls $avatarUrls = null;

    private ?string $displayName = null;

    private ?string $emailAddress = null;

    private ?string $key = null;

    private ?string $name = null;

    private ?string $self = null;

    private ?string $timeZone = null;

    public function getAccountId(): ?string
    {
        return $this->accountId;
    }

    public function setAccountId(?string $accountId): static
    {
        $this->accountId = $accountId;

        return $this;
    }

    public function getAccountType(): ?AccountType
    {
        return $this->accountType;
    }

    public function setAccountType(?AccountType $accountType): static
    {
        $this->accountType = $accountType;

        return $this;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    public function getAvatarUrls(): ?Urls
    {
        return $this->avatarUrls;
    }

    public function setAvatarUrls(?Urls $avatarUrls): static
    {
        $this->avatarUrls = $avatarUrls;

        return $this;
    }

    public function getDisplayName(): ?string
    {
        return $this->displayName;
    }

    public function setDisplayName(?string $displayName): static
    {
        $this->displayName = $displayName;

        return $this;
    }

    public function getEmailAddress(): ?string
    {
        return $this->emailAddress;
    }

    public function setEmailAddress(?string $emailAddress): static
    {
        $this->emailAddress = $emailAddress;

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

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

    public function getTimeZone(): ?string
    {
        return $this->timeZone;
    }

    public function setTimeZone(?string $timeZone): static
    {
        $this->timeZone = $timeZone;

        return $this;
    }
}
