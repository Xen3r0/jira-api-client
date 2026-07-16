<?php

namespace Xen3r0\JiraApiClient\Tests\Model\Project;

use PHPUnit\Framework\TestCase;
use Xen3r0\JiraApiClient\Model\Project\Insight;

class InsightTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $lastIssueUpdateTime = new \DateTimeImmutable('2025-08-18');

        $insight = (new Insight())
            ->setLastIssueUpdateTime($lastIssueUpdateTime)
            ->setTotalIssueCount(42);

        $this->assertEquals($lastIssueUpdateTime, $insight->getLastIssueUpdateTime());
        $this->assertEquals(42, $insight->getTotalIssueCount());
    }
}
