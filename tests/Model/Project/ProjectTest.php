<?php

namespace Xen3r0\JiraApiClient\Tests\Model\Project;

use PHPUnit\Framework\TestCase;
use Xen3r0\JiraApiClient\Enum\Project\AssigneeType;
use Xen3r0\JiraApiClient\Enum\Project\Style;
use Xen3r0\JiraApiClient\Model\Avatar\Urls;
use Xen3r0\JiraApiClient\Model\Issue\Type;
use Xen3r0\JiraApiClient\Model\Project\Category;
use Xen3r0\JiraApiClient\Model\Project\Component;
use Xen3r0\JiraApiClient\Model\Project\Insight;
use Xen3r0\JiraApiClient\Model\Project\Project;
use Xen3r0\JiraApiClient\Model\User\User;
use Xen3r0\JiraApiClient\Model\Version\Version;

class ProjectTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $avatarUrls = (new Urls())->setX48('https://example.atlassian.net/avatar/48.png');
        $version = (new Version())->setName('1.0.0');
        $issueType = (new Type())->setName('Bug');
        $component = (new Component())->setName('Component 1');
        $insight = (new Insight())->setTotalIssueCount(10);
        $lead = (new User())->setDisplayName('John Doe');
        $category = (new Category())->setName('Support');

        $project = (new Project())
            ->setId('10000')
            ->setKey('TEST')
            ->setName('Test project')
            ->setDescription('A test project')
            ->setSelf('https://example.atlassian.net/rest/api/3/project/10000')
            ->setProjectTypeKey('software')
            ->setEmail('project-lead@example.com')
            ->setSimplified(true)
            ->setStyle(Style::NextGen)
            ->setUrl('https://example.atlassian.net/projects/TEST')
            ->setVersions([$version])
            ->setRoles(['Developer' => 'https://example.atlassian.net/rest/api/3/project/TEST/role/10000'])
            ->setProperties(['key' => 'value'])
            ->setIssueTypes([$issueType])
            ->setAssigneeType(AssigneeType::ProjectLead)
            ->setAvatarUrls($avatarUrls)
            ->setComponents(['Component 1' => $component])
            ->setInsight($insight)
            ->setLead($lead)
            ->setProjectCategory($category);

        $this->assertEquals('10000', $project->getId());
        $this->assertEquals('TEST', $project->getKey());
        $this->assertEquals('Test project', $project->getName());
        $this->assertEquals('A test project', $project->getDescription());
        $this->assertEquals('https://example.atlassian.net/rest/api/3/project/10000', $project->getSelf());
        $this->assertEquals('software', $project->getProjectTypeKey());
        $this->assertEquals('project-lead@example.com', $project->getEmail());
        $this->assertTrue($project->isSimplified());
        $this->assertSame(Style::NextGen, $project->getStyle());
        $this->assertEquals('https://example.atlassian.net/projects/TEST', $project->getUrl());
        $this->assertSame([$version], $project->getVersions());
        $this->assertEquals(['Developer' => 'https://example.atlassian.net/rest/api/3/project/TEST/role/10000'], $project->getRoles());
        $this->assertEquals(['key' => 'value'], $project->getProperties());
        $this->assertSame([$issueType], $project->getIssueTypes());
        $this->assertSame(AssigneeType::ProjectLead, $project->getAssigneeType());
        $this->assertSame($avatarUrls, $project->getAvatarUrls());
        $this->assertSame(['Component 1' => $component], $project->getComponents());
        $this->assertSame($insight, $project->getInsight());
        $this->assertSame($lead, $project->getLead());
        $this->assertSame($category, $project->getProjectCategory());
    }
}
