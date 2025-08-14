<?php

namespace Xen3r0\JiraApiClient\Tests\Repository\Project;

use Symfony\Contracts\HttpClient\ResponseInterface;
use Xen3r0\JiraApiClient\Http\JiraClient;
use Xen3r0\JiraApiClient\Repository\Project\ProjectRepository;
use Xen3r0\JiraApiClient\Tests\Repository\AbstractRepositoryTestCase;

class ProjectRepositoryTest extends AbstractRepositoryTestCase
{
    public function testFindAll(): void
    {
        $content = $this->getFixtureContent('Project/get_project_search.json');
        $jiraClient = $this->createMock(JiraClient::class);
        $response = $this->createMock(ResponseInterface::class);

        $jiraClient
            ->expects($this->once())
            ->method('get')
            ->with('project/search')
            ->willReturn($response);

        $response
            ->expects($this->once())
            ->method('getContent')
            ->willReturn($content);

        $repository = new ProjectRepository($jiraClient);
        $actual = $repository->findAll('QA');
        $this->assertNotEmpty($actual->getValues());
    }

    public function testFindByIdOrKey(): void
    {
        $content = $this->getFixtureContent('Project/get_project.json');
        $jiraClient = $this->createMock(JiraClient::class);
        $response = $this->createMock(ResponseInterface::class);

        $jiraClient
            ->expects($this->once())
            ->method('get')
            ->with('project/QA')
            ->willReturn($response);

        $response
            ->expects($this->once())
            ->method('getContent')
            ->willReturn($content);

        $repository = new ProjectRepository($jiraClient);
        $actual = $repository->findByIdOrKey('QA');
        $this->assertNotNull($actual);
        $this->assertNotEmpty($actual->getIssueTypes());
        $this->assertNotEmpty($actual->getVersions());
    }
}
