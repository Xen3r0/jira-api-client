<?php

namespace Xen3r0\JiraApiClient\Model\Project;

class Insight
{
    private ?\DateTimeImmutable $lastIssueUpdateTime = null;

    private int $totalIssueCount = 0;

    public function getLastIssueUpdateTime(): ?\DateTimeImmutable
    {
        return $this->lastIssueUpdateTime;
    }

    public function setLastIssueUpdateTime(?\DateTimeImmutable $lastIssueUpdateTime): static
    {
        $this->lastIssueUpdateTime = $lastIssueUpdateTime;

        return $this;
    }

    public function getTotalIssueCount(): int
    {
        return $this->totalIssueCount;
    }

    public function setTotalIssueCount(int $totalIssueCount): static
    {
        $this->totalIssueCount = $totalIssueCount;

        return $this;
    }
}
