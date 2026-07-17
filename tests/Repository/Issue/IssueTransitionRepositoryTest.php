<?php

namespace Xen3r0\JiraApiClient\Tests\Repository\Issue;

use Symfony\Contracts\HttpClient\ResponseInterface;
use Xen3r0\JiraApiClient\Http\JiraClientInterface;
use Xen3r0\JiraApiClient\Repository\Issue\IssueTransitionRepository;
use Xen3r0\JiraApiClient\Tests\Repository\AbstractRepositoryTestCase;

class IssueTransitionRepositoryTest extends AbstractRepositoryTestCase
{
    public function testFindAll(): void
    {
        $content = $this->getFixtureContent('Issue/get_transitions.json');
        $jiraClient = $this->createMock(JiraClientInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $jiraClient
            ->expects($this->once())
            ->method('get')
            ->with('issue/QA-6921/transitions')
            ->willReturn($response);

        $response
            ->expects($this->once())
            ->method('getContent')
            ->willReturn($content);

        $repository = new IssueTransitionRepository($jiraClient);
        $actual = $repository->findAll('QA-6921');

        $this->assertCount(2, $actual->getTransitions());
        $this->assertEquals('11', $actual->getTransitions()[0]->getId());
        $this->assertEquals('To Do', $actual->getTransitions()[0]->getName());
        $this->assertEquals('10000', $actual->getTransitions()[0]->getTo()?->getId());
        $this->assertTrue($actual->getTransitions()[0]->getIsAvailable());
    }

    public function testTransition(): void
    {
        $jiraClient = $this->createMock(JiraClientInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $jiraClient
            ->expects($this->once())
            ->method('post')
            ->with('issue/QA-6921/transitions', ['transition' => ['id' => '21']])
            ->willReturn($response);

        $repository = new IssueTransitionRepository($jiraClient);
        $repository->transition('QA-6921', '21');
    }
}
