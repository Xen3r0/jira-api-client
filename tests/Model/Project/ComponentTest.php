<?php

namespace Xen3r0\JiraApiClient\Tests\Model\Project;

use PHPUnit\Framework\TestCase;
use Xen3r0\JiraApiClient\Model\Project\Component;
use Xen3r0\JiraApiClient\Model\User\User;

class ComponentTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $assignee = (new User())->setDisplayName('John Doe');
        $lead = (new User())->setDisplayName('Jane Doe');
        $realAssignee = (new User())->setDisplayName('John Doe');

        $component = (new Component())
            ->setAri('ari:cloud:jira:00000000-0000-0000-0000-000000000000:component/10000')
            ->setAssignee($assignee)
            ->setAssigneeType('PROJECT_LEAD')
            ->setDescription('This is a Jira component')
            ->setId('10000')
            ->setIsAssigneeTypeValid(true)
            ->setLead($lead)
            ->setMetadata(['key' => 'value'])
            ->setName('Component 1')
            ->setProject('TEST')
            ->setProjectId(10000)
            ->setRealAssignee($realAssignee)
            ->setRealAssigneeType('PROJECT_LEAD')
            ->setSelf('https://example.atlassian.net/rest/api/3/component/10000');

        $this->assertEquals('ari:cloud:jira:00000000-0000-0000-0000-000000000000:component/10000', $component->getAri());
        $this->assertSame($assignee, $component->getAssignee());
        $this->assertEquals('PROJECT_LEAD', $component->getAssigneeType());
        $this->assertEquals('This is a Jira component', $component->getDescription());
        $this->assertEquals('10000', $component->getId());
        $this->assertTrue($component->isAssigneeTypeValid());
        $this->assertSame($lead, $component->getLead());
        $this->assertEquals(['key' => 'value'], $component->getMetadata());
        $this->assertEquals('Component 1', $component->getName());
        $this->assertEquals('TEST', $component->getProject());
        $this->assertEquals(10000, $component->getProjectId());
        $this->assertSame($realAssignee, $component->getRealAssignee());
        $this->assertEquals('PROJECT_LEAD', $component->getRealAssigneeType());
        $this->assertEquals('https://example.atlassian.net/rest/api/3/component/10000', $component->getSelf());
    }
}
