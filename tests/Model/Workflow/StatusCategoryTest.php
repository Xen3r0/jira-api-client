<?php

namespace Xen3r0\JiraApiClient\Tests\Model\Workflow;

use PHPUnit\Framework\TestCase;
use Xen3r0\JiraApiClient\Model\Workflow\StatusCategory;

class StatusCategoryTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $statusCategory = (new StatusCategory())
            ->setId(4)
            ->setKey('indeterminate')
            ->setName('In Progress')
            ->setColorName('yellow')
            ->setSelf('https://example.atlassian.net/rest/api/3/statuscategory/4');

        $this->assertEquals(4, $statusCategory->getId());
        $this->assertEquals('indeterminate', $statusCategory->getKey());
        $this->assertEquals('In Progress', $statusCategory->getName());
        $this->assertEquals('yellow', $statusCategory->getColorName());
        $this->assertEquals('https://example.atlassian.net/rest/api/3/statuscategory/4', $statusCategory->getSelf());
    }
}
