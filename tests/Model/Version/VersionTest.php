<?php

namespace Xen3r0\JiraApiClient\Tests\Model\Version;

use PHPUnit\Framework\TestCase;
use Xen3r0\JiraApiClient\Model\Version\Version;

class VersionTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $startDate = new \DateTimeImmutable('2025-08-01');
        $releaseDate = new \DateTimeImmutable('2025-08-18');

        $version = (new Version())
            ->setId('2000')
            ->setProjectId(10000)
            ->setName('2.1.0')
            ->setDescription('Release 2.1.0')
            ->setSelf('https://example.atlassian.net/rest/api/3/version/2000')
            ->setArchived(false)
            ->setStartDate($startDate)
            ->setUserStartDate('01/Aug/25')
            ->setReleased(true)
            ->setReleaseDate($releaseDate)
            ->setUserReleaseDate('18/Aug/25')
            ->setOverdue(false)
            ->setExpand('operations')
            ->setMoveUnfixedIssuesTo('https://example.atlassian.net/rest/api/3/version/2001');

        $this->assertEquals('2000', $version->getId());
        $this->assertEquals(10000, $version->getProjectId());
        $this->assertEquals('2.1.0', $version->getName());
        $this->assertEquals('Release 2.1.0', $version->getDescription());
        $this->assertEquals('https://example.atlassian.net/rest/api/3/version/2000', $version->getSelf());
        $this->assertFalse($version->getArchived());
        $this->assertEquals($startDate, $version->getStartDate());
        $this->assertEquals('01/Aug/25', $version->getUserStartDate());
        $this->assertTrue($version->getReleased());
        $this->assertEquals($releaseDate, $version->getReleaseDate());
        $this->assertEquals('18/Aug/25', $version->getUserReleaseDate());
        $this->assertFalse($version->getOverdue());
        $this->assertEquals('operations', $version->getExpand());
        $this->assertEquals('https://example.atlassian.net/rest/api/3/version/2001', $version->getMoveUnfixedIssuesTo());
    }
}
