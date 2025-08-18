<?php

namespace Xen3r0\JiraApiClient\Model\Project;

use Xen3r0\JiraApiClient\Enum\Project\AssigneeType;
use Xen3r0\JiraApiClient\Enum\Project\Style;
use Xen3r0\JiraApiClient\Model\Avatar\Urls;
use Xen3r0\JiraApiClient\Model\Issue\Type;
use Xen3r0\JiraApiClient\Model\User\User;
use Xen3r0\JiraApiClient\Model\Version\Version;

class Project
{
    private ?string $id = null;

    private ?string $key = null;

    private ?string $name = null;

    private ?string $description = null;

    private ?string $self = null;

    private ?string $projectTypeKey = null;

    private ?string $email = null;

    private bool $simplified = false;

    private ?Style $style = null;

    private ?string $url = null;

    /**
     * @var array<int, Version>
     */
    private array $versions = [];

    /**
     * @var array<string, string>
     */
    private array $roles = [];

    /**
     * @var array<string, string>
     */
    private array $properties = [];

    /**
     * @var array<int, Type>
     */
    private array $issueTypes = [];

    private ?AssigneeType $assigneeType = null;

    private ?Urls $avatarUrls = null;

    /**
     * @var array<string, Component>
     */
    private array $components = [];

    private ?Insight $insight = null;

    private ?User $lead = null;

    private ?Category $projectCategory = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): static
    {
        $this->id = $id;

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

    public function getProjectTypeKey(): ?string
    {
        return $this->projectTypeKey;
    }

    public function setProjectTypeKey(?string $projectTypeKey): static
    {
        $this->projectTypeKey = $projectTypeKey;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function isSimplified(): bool
    {
        return $this->simplified;
    }

    public function setSimplified(bool $simplified): static
    {
        $this->simplified = $simplified;

        return $this;
    }

    public function getStyle(): ?Style
    {
        return $this->style;
    }

    public function setStyle(?Style $style): static
    {
        $this->style = $style;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): static
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return array<int, Version>
     */
    public function getVersions(): array
    {
        return $this->versions;
    }

    /**
     * @param array<int, Version> $versions
     */
    public function setVersions(array $versions): static
    {
        $this->versions = $versions;

        return $this;
    }

    /**
     * @return array<string, string>
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param array<string, string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return array<string, string>
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * @param array<string, string> $properties
     */
    public function setProperties(array $properties): static
    {
        $this->properties = $properties;

        return $this;
    }

    /**
     * @return array<int, Type>
     */
    public function getIssueTypes(): array
    {
        return $this->issueTypes;
    }

    /**
     * @param array<int, Type> $issueTypes
     */
    public function setIssueTypes(array $issueTypes): static
    {
        $this->issueTypes = $issueTypes;

        return $this;
    }

    public function getAssigneeType(): ?AssigneeType
    {
        return $this->assigneeType;
    }

    public function setAssigneeType(?AssigneeType $assigneeType): static
    {
        $this->assigneeType = $assigneeType;

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

    /**
     * @return array<string, Component>
     */
    public function getComponents(): array
    {
        return $this->components;
    }

    /**
     * @param array<string, Component> $components
     */
    public function setComponents(array $components): static
    {
        $this->components = $components;

        return $this;
    }

    public function getInsight(): ?Insight
    {
        return $this->insight;
    }

    public function setInsight(?Insight $insight): static
    {
        $this->insight = $insight;

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

    public function getProjectCategory(): ?Category
    {
        return $this->projectCategory;
    }

    public function setProjectCategory(?Category $projectCategory): static
    {
        $this->projectCategory = $projectCategory;

        return $this;
    }
}
