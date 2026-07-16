<?php

namespace Xen3r0\JiraApiClient\Tests\Model\Status;

use PHPUnit\Framework\TestCase;
use Xen3r0\JiraApiClient\Model\Status\Status;
use Xen3r0\JiraApiClient\Model\Workflow\StatusCategory;

class StatusTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $statusCategory = (new StatusCategory())->setName('In Progress');

        $status = (new Status())
            ->setId('3')
            ->setName('In Progress')
            ->setDescription('This issue is being actively worked on.')
            ->setSelf('https://example.atlassian.net/rest/api/3/status/3')
            ->setStatusCategory($statusCategory);

        $this->assertEquals('3', $status->getId());
        $this->assertEquals('In Progress', $status->getName());
        $this->assertEquals('This issue is being actively worked on.', $status->getDescription());
        $this->assertEquals('https://example.atlassian.net/rest/api/3/status/3', $status->getSelf());
        $this->assertSame($statusCategory, $status->getStatusCategory());
    }
}
