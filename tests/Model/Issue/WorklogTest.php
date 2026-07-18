<?php

namespace Xen3r0\JiraApiClient\Tests\Model\Issue;

use PHPUnit\Framework\TestCase;
use Xen3r0\Adf\Node\Block\Document;
use Xen3r0\JiraApiClient\Model\Issue\Visiblity;
use Xen3r0\JiraApiClient\Model\Issue\Worklog;
use Xen3r0\JiraApiClient\Model\User\User;

class WorklogTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $author = (new User())->setDisplayName('John Doe');
        $updateAuthor = (new User())->setDisplayName('Jane Doe');
        $created = new \DateTimeImmutable('2025-08-18T10:00:00+00:00');
        $updated = new \DateTimeImmutable('2025-08-19T10:00:00+00:00');
        $started = new \DateTimeImmutable('2025-08-18T09:00:00+00:00');
        $comment = new Document();
        $visibility = (new Visiblity())->setType('role')->setValue('Administrators');

        $worklog = (new Worklog())
            ->setId('10000')
            ->setSelf('https://example.atlassian.net/rest/api/3/issue/TEST-1/worklog/10000')
            ->setIssueId('10001')
            ->setAuthor($author)
            ->setUpdateAuthor($updateAuthor)
            ->setComment($comment)
            ->setCreated($created)
            ->setUpdated($updated)
            ->setStarted($started)
            ->setTimeSpent('3h 20m')
            ->setTimeSpentSeconds(12000)
            ->setVisibility($visibility);

        $this->assertEquals('10000', $worklog->getId());
        $this->assertEquals('https://example.atlassian.net/rest/api/3/issue/TEST-1/worklog/10000', $worklog->getSelf());
        $this->assertEquals('10001', $worklog->getIssueId());
        $this->assertSame($author, $worklog->getAuthor());
        $this->assertSame($updateAuthor, $worklog->getUpdateAuthor());
        $this->assertSame($comment, $worklog->getComment());
        $this->assertEquals($created, $worklog->getCreated());
        $this->assertEquals($updated, $worklog->getUpdated());
        $this->assertEquals($started, $worklog->getStarted());
        $this->assertEquals('3h 20m', $worklog->getTimeSpent());
        $this->assertEquals(12000, $worklog->getTimeSpentSeconds());
        $this->assertSame($visibility, $worklog->getVisibility());
    }
}
