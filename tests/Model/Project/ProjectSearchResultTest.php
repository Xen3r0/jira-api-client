<?php

namespace Xen3r0\JiraApiClient\Tests\Model\Project;

use PHPUnit\Framework\TestCase;
use Xen3r0\JiraApiClient\Model\Project\Project;
use Xen3r0\JiraApiClient\Model\Project\ProjectSearchResult;

class ProjectSearchResultTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $project = (new Project())->setKey('TEST');

        $result = (new ProjectSearchResult())
            ->setIsLast(true)
            ->setStartAt(0)
            ->setMaxResults(50)
            ->setTotal(1)
            ->setNextPage('https://example.atlassian.net/rest/api/3/project/search?startAt=50')
            ->setValues([$project])
            ->setSelf('https://example.atlassian.net/rest/api/3/project/search');

        $this->assertTrue($result->getIsLast());
        $this->assertEquals(0, $result->getStartAt());
        $this->assertEquals(50, $result->getMaxResults());
        $this->assertEquals(1, $result->getTotal());
        $this->assertEquals('https://example.atlassian.net/rest/api/3/project/search?startAt=50', $result->getNextPage());
        $this->assertSame([$project], $result->getValues());
        $this->assertEquals('https://example.atlassian.net/rest/api/3/project/search', $result->getSelf());
    }
}
