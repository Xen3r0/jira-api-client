<?php

namespace Xen3r0\JiraApiClient\Model\Issue;

class Link
{
    private ?string $id = null;

    private ?Issue $inwardIssue = null;

    private ?Issue $outwardIssue = null;

    private ?LinkType $type = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getInwardIssue(): ?Issue
    {
        return $this->inwardIssue;
    }

    public function setInwardIssue(?Issue $inwardIssue): static
    {
        $this->inwardIssue = $inwardIssue;

        return $this;
    }

    public function getOutwardIssue(): ?Issue
    {
        return $this->outwardIssue;
    }

    public function setOutwardIssue(?Issue $outwardIssue): static
    {
        $this->outwardIssue = $outwardIssue;

        return $this;
    }

    public function getType(): ?LinkType
    {
        return $this->type;
    }

    public function setType(?LinkType $type): static
    {
        $this->type = $type;

        return $this;
    }
}
