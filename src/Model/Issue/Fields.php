<?php

namespace Xen3r0\JiraApiClient\Model\Issue;

use DH\Adf\Node\Block\Document;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Xen3r0\JiraApiClient\Model\Project\Component;
use Xen3r0\JiraApiClient\Model\Project\Project;
use Xen3r0\JiraApiClient\Model\Status\Status;
use Xen3r0\JiraApiClient\Model\User\User;
use Xen3r0\JiraApiClient\Model\Version\Version;
use Xen3r0\JiraApiClient\Model\Workflow\StatusCategory;

class Fields
{
    private ?string $summary = null;

    private ?Issue $parent = null;

    /**
     * @var array<int, Version>
     */
    private array $fixVersions = [];

    #[SerializedName('statuscategorychangedate')]
    private ?\DateTimeImmutable $statusCategoryChangeDate;

    private ?StatusCategory $statusCategory = null;

    private ?Resolution $resolution = null;

    private ?Priority $priority = null;

    /**
     * @var array<int, string>
     */
    private array $labels = [];

    #[SerializedName('aggregatetimeoriginalestimate')]
    private ?int $aggregateTimeOriginalEstimate = null;

    #[SerializedName('timeestimate')]
    private ?int $timeEstimate = null;

    /**
     * @var array<int, Version>
     */
    private array $versions = [];

    /**
     * @var array<int, Link>
     */
    private array $issuelinks = [];

    private ?User $assignee = null;

    private ?Status $status = null;

    /**
     * @var array<int, Component>
     */
    private array $components = [];

    #[SerializedName('aggregatetimeestimate')]
    private ?int $aggregateTimeEstimate = null;

    private ?User $creator = null;

    /**
     * @var array<int, Issue>
     */
    private array $subtasks = [];

    private ?User $reporter = null;

    #[SerializedName('aggregateprogress')]
    private ?Progress $aggregateProgress = null;

    private ?Progress $progress = null;

    private ?Votes $votes = null;

    #[SerializedName('issuetype')]
    private ?Type $issueType = null;

    #[SerializedName('timespent')]
    private ?int $timeSpent = null;

    private ?Project $project = null;

    #[SerializedName('aggregatetimespent')]
    private ?int $aggregateTimeSpent = null;

    #[SerializedName('resolutiondate')]
    private ?\DateTimeImmutable $resolutionDate = null;

    private ?int $workRatio = null;

    private ?Watches $watches = null;

    private ?\DateTimeImmutable $created = null;

    private ?\DateTimeImmutable $updated = null;

    #[SerializedName('timeoriginalestimate')]
    private ?int $timeOriginalEstimate = null;

    private ?Document $description = null;

    #[SerializedName('duedate')]
    private ?\DateTimeImmutable $dueDate = null;

    /**
     * @var array<string, CustomField>
     */
    private array $customFields = [];

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(?string $summary): static
    {
        $this->summary = $summary;

        return $this;
    }

    public function getParent(): ?Issue
    {
        return $this->parent;
    }

    public function setParent(?Issue $parent): static
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return array<int, Version>
     */
    public function getFixVersions(): array
    {
        return $this->fixVersions;
    }

    /**
     * @param array<int, Version> $fixVersions
     */
    public function setFixVersions(array $fixVersions): static
    {
        $this->fixVersions = $fixVersions;

        return $this;
    }

    public function getStatusCategoryChangeDate(): ?\DateTimeImmutable
    {
        return $this->statusCategoryChangeDate;
    }

    public function setStatusCategoryChangeDate(?\DateTimeImmutable $statusCategoryChangeDate): static
    {
        $this->statusCategoryChangeDate = $statusCategoryChangeDate;

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

    public function getResolution(): ?Resolution
    {
        return $this->resolution;
    }

    public function setResolution(?Resolution $resolution): static
    {
        $this->resolution = $resolution;

        return $this;
    }

    public function getPriority(): ?Priority
    {
        return $this->priority;
    }

    public function setPriority(?Priority $priority): static
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * @return array<int, string>
     */
    public function getLabels(): array
    {
        return $this->labels;
    }

    /**
     * @param array<int, string> $labels
     */
    public function setLabels(array $labels): static
    {
        $this->labels = $labels;

        return $this;
    }

    public function getAggregateTimeOriginalEstimate(): ?int
    {
        return $this->aggregateTimeOriginalEstimate;
    }

    public function setAggregateTimeOriginalEstimate(?int $aggregateTimeOriginalEstimate): static
    {
        $this->aggregateTimeOriginalEstimate = $aggregateTimeOriginalEstimate;

        return $this;
    }

    public function getTimeEstimate(): ?int
    {
        return $this->timeEstimate;
    }

    public function setTimeEstimate(?int $timeEstimate): static
    {
        $this->timeEstimate = $timeEstimate;

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
     * @return array<int, Link>
     */
    public function getIssuelinks(): array
    {
        return $this->issuelinks;
    }

    /**
     * @param array<int, Link> $issuelinks
     */
    public function setIssuelinks(array $issuelinks): static
    {
        $this->issuelinks = $issuelinks;

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

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return array<int, Component>
     */
    public function getComponents(): array
    {
        return $this->components;
    }

    /**
     * @param array<int, Component> $components
     */
    public function setComponents(array $components): static
    {
        $this->components = $components;

        return $this;
    }

    public function getAggregateTimeEstimate(): ?int
    {
        return $this->aggregateTimeEstimate;
    }

    public function setAggregateTimeEstimate(?int $aggregateTimeEstimate): static
    {
        $this->aggregateTimeEstimate = $aggregateTimeEstimate;

        return $this;
    }

    public function getCreator(): ?User
    {
        return $this->creator;
    }

    public function setCreator(?User $creator): static
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * @return array<int, Issue>
     */
    public function getSubtasks(): array
    {
        return $this->subtasks;
    }

    public function getReporter(): ?User
    {
        return $this->reporter;
    }

    public function setReporter(?User $reporter): static
    {
        $this->reporter = $reporter;

        return $this;
    }

    public function getAggregateProgress(): ?Progress
    {
        return $this->aggregateProgress;
    }

    public function setAggregateProgress(?Progress $aggregateProgress): static
    {
        $this->aggregateProgress = $aggregateProgress;

        return $this;
    }

    public function getProgress(): ?Progress
    {
        return $this->progress;
    }

    public function setProgress(?Progress $progress): static
    {
        $this->progress = $progress;

        return $this;
    }

    public function getVotes(): ?Votes
    {
        return $this->votes;
    }

    public function setVotes(?Votes $votes): static
    {
        $this->votes = $votes;

        return $this;
    }

    /**
     * @param array<int, Issue> $subtasks
     */
    public function setSubtasks(array $subtasks): static
    {
        $this->subtasks = $subtasks;

        return $this;
    }

    public function getIssueType(): ?Type
    {
        return $this->issueType;
    }

    public function setIssueType(?Type $issueType): static
    {
        $this->issueType = $issueType;

        return $this;
    }

    public function getTimeSpent(): ?int
    {
        return $this->timeSpent;
    }

    public function setTimeSpent(?int $timeSpent): static
    {
        $this->timeSpent = $timeSpent;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): static
    {
        $this->project = $project;

        return $this;
    }

    public function getAggregateTimeSpent(): ?int
    {
        return $this->aggregateTimeSpent;
    }

    public function setAggregateTimeSpent(?int $aggregateTimeSpent): static
    {
        $this->aggregateTimeSpent = $aggregateTimeSpent;

        return $this;
    }

    public function getResolutionDate(): ?\DateTimeImmutable
    {
        return $this->resolutionDate;
    }

    public function setResolutionDate(?\DateTimeImmutable $resolutionDate): static
    {
        $this->resolutionDate = $resolutionDate;

        return $this;
    }

    public function getWorkRatio(): ?int
    {
        return $this->workRatio;
    }

    public function setWorkRatio(?int $workRatio): static
    {
        $this->workRatio = $workRatio;

        return $this;
    }

    public function getWatches(): ?Watches
    {
        return $this->watches;
    }

    public function setWatches(?Watches $watches): static
    {
        $this->watches = $watches;

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

    public function getTimeOriginalEstimate(): ?int
    {
        return $this->timeOriginalEstimate;
    }

    public function setTimeOriginalEstimate(?int $timeOriginalEstimate): static
    {
        $this->timeOriginalEstimate = $timeOriginalEstimate;

        return $this;
    }

    public function getDescription(): ?Document
    {
        return $this->description;
    }

    public function setDescription(?Document $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDueDate(): ?\DateTimeImmutable
    {
        return $this->dueDate;
    }

    public function setDueDate(?\DateTimeImmutable $dueDate): static
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    /**
     * @return array<string, CustomField>
     */
    public function getCustomFields(): array
    {
        return $this->customFields;
    }

    public function setCustomField(string $key, CustomField $customField): static
    {
        $this->customFields[$key] = $customField;

        return $this;
    }

    /**
     * @param array<string, CustomField> $customFields
     */
    public function setCustomFields(array $customFields): static
    {
        $this->customFields = $customFields;

        return $this;
    }
}
