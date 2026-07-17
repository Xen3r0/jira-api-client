<?php

namespace Xen3r0\JiraApiClient\Tests\Repository\Issue;

use Symfony\Contracts\HttpClient\ResponseInterface;
use Xen3r0\JiraApiClient\Http\JiraClientInterface;
use Xen3r0\JiraApiClient\Model\Issue\Issue;
use Xen3r0\JiraApiClient\Model\Issue\Link;
use Xen3r0\JiraApiClient\Model\Issue\LinkType;
use Xen3r0\JiraApiClient\Repository\Issue\IssueLinkRepository;
use Xen3r0\JiraApiClient\Tests\Repository\AbstractRepositoryTestCase;

class IssueLinkRepositoryTest extends AbstractRepositoryTestCase
{
    public function testAdd(): void
    {
        $link = (new Link())
            ->setInwardIssue((new Issue())->setKey('QA-1'))
            ->setOutwardIssue((new Issue())->setKey('QA-2'))
            ->setType((new LinkType())->setName('Blocks'));

        $payload = json_encode([
            'inwardIssue' => ['key' => 'QA-1'],
            'outwardIssue' => ['key' => 'QA-2'],
            'type' => ['name' => 'Blocks'],
        ]);
        $this->assertIsString($payload);

        $jiraClient = $this->createMock(JiraClientInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $jiraClient
            ->expects($this->once())
            ->method('post')
            ->with('issueLink', $payload)
            ->willReturn($response);

        $repository = new IssueLinkRepository($jiraClient);
        $repository->add($link);
    }

    public function testFindById(): void
    {
        $content = $this->getFixtureContent('Issue/get_link.json');
        $jiraClient = $this->createMock(JiraClientInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $jiraClient
            ->expects($this->once())
            ->method('get')
            ->with('issueLink/10001')
            ->willReturn($response);

        $response
            ->expects($this->once())
            ->method('getContent')
            ->willReturn($content);

        $repository = new IssueLinkRepository($jiraClient);
        $actual = $repository->findById('10001');

        $this->assertInstanceOf(Link::class, $actual);
        $this->assertEquals('QA-1', $actual->getInwardIssue()?->getKey());
        $this->assertEquals('QA-2', $actual->getOutwardIssue()?->getKey());
        $this->assertEquals('Blocks', $actual->getType()?->getName());
    }

    public function testRemove(): void
    {
        $jiraClient = $this->createMock(JiraClientInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $jiraClient
            ->expects($this->once())
            ->method('delete')
            ->with('issueLink/10001')
            ->willReturn($response);

        $repository = new IssueLinkRepository($jiraClient);
        $repository->remove('10001');
    }
}
