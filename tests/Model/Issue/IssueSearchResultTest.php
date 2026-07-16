<?php

namespace Xen3r0\JiraApiClient\Tests\Model\Issue;

use PHPUnit\Framework\TestCase;
use Xen3r0\JiraApiClient\Model\Issue\Issue;
use Xen3r0\JiraApiClient\Model\Issue\IssueSearchResult;

class IssueSearchResultTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $issue = (new Issue())->setKey('TEST-1');

        $result = (new IssueSearchResult())
            ->setIssues([$issue])
            ->setIsLast(true)
            ->setNextPageToken('next-page-token');

        $this->assertSame([$issue], $result->getIssues());
        $this->assertTrue($result->getIsLast());
        $this->assertEquals('next-page-token', $result->getNextPageToken());
    }
}
