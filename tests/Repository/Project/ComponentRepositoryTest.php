<?php

namespace Xen3r0\JiraApiClient\Tests\Repository\Project;

use Symfony\Contracts\HttpClient\ResponseInterface;
use Xen3r0\JiraApiClient\Exception\Project\ComponentMustBeExistsException;
use Xen3r0\JiraApiClient\Http\JiraClientInterface;
use Xen3r0\JiraApiClient\Model\Project\Component;
use Xen3r0\JiraApiClient\Repository\Project\ComponentRepository;
use Xen3r0\JiraApiClient\Tests\Repository\AbstractRepositoryTestCase;

class ComponentRepositoryTest extends AbstractRepositoryTestCase
{
    public function testFindById(): void
    {
        $content = $this->getFixtureContent('Project/get_component.json');
        $jiraClient = $this->createMock(JiraClientInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $jiraClient
            ->expects($this->once())
            ->method('get')
            ->with('component/10000')
            ->willReturn($response);

        $response
            ->expects($this->once())
            ->method('getContent')
            ->willReturn($content);

        $repository = new ComponentRepository($jiraClient);
        $actual = $repository->findById('10000');

        $this->assertInstanceOf(Component::class, $actual);
        $this->assertEquals('Component 1', $actual->getName());
        $this->assertEquals('TEST', $actual->getProject());
    }

    public function testAdd(): void
    {
        $component = (new Component())
            ->setName('Component 1')
            ->setDescription('This is a Jira component')
            ->setProject('TEST')
            ->setAssigneeType('PROJECT_LEAD')
            ->setLeadAccountId('5b10a2844c20165700ede21g');

        $payload = json_encode([
            'assigneeType' => 'PROJECT_LEAD',
            'description' => 'This is a Jira component',
            'leadAccountId' => '5b10a2844c20165700ede21g',
            'name' => 'Component 1',
            'project' => 'TEST',
        ]);
        $this->assertIsString($payload);

        $content = $this->getFixtureContent('Project/get_component.json');
        $jiraClient = $this->createMock(JiraClientInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $jiraClient
            ->expects($this->once())
            ->method('post')
            ->with('component', $payload)
            ->willReturn($response);

        $response
            ->expects($this->once())
            ->method('getContent')
            ->willReturn($content);

        $repository = new ComponentRepository($jiraClient);
        $actual = $repository->add($component);

        $this->assertInstanceOf(Component::class, $actual);
        $this->assertEquals('10000', $actual->getId());
    }

    public function testUpdate(): void
    {
        $component = (new Component())
            ->setId('10000')
            ->setName('Component 1')
            ->setDescription('This is a Jira component')
            ->setProject('TEST')
            ->setAssigneeType('PROJECT_LEAD')
            ->setLeadAccountId('5b10a2844c20165700ede21g');

        $payload = json_encode([
            'assigneeType' => 'PROJECT_LEAD',
            'description' => 'This is a Jira component',
            'leadAccountId' => '5b10a2844c20165700ede21g',
            'name' => 'Component 1',
            'project' => 'TEST',
        ]);
        $this->assertIsString($payload);

        $content = $this->getFixtureContent('Project/get_component.json');
        $jiraClient = $this->createMock(JiraClientInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $jiraClient
            ->expects($this->once())
            ->method('put')
            ->with('component/10000', $payload)
            ->willReturn($response);

        $response
            ->expects($this->once())
            ->method('getContent')
            ->willReturn($content);

        $repository = new ComponentRepository($jiraClient);
        $actual = $repository->update($component);

        $this->assertInstanceOf(Component::class, $actual);
        $this->assertEquals('10000', $actual->getId());
    }

    public function testUpdateOnNewComponent(): void
    {
        $component = (new Component())->setName('Component 1');

        $jiraClient = $this->createMock(JiraClientInterface::class);

        $this->expectException(ComponentMustBeExistsException::class);

        $repository = new ComponentRepository($jiraClient);
        $repository->update($component);
    }

    public function testRemove(): void
    {
        $jiraClient = $this->createMock(JiraClientInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $jiraClient
            ->expects($this->once())
            ->method('delete')
            ->with('component/10000')
            ->willReturn($response);

        $repository = new ComponentRepository($jiraClient);
        $repository->remove('10000');
    }
}
