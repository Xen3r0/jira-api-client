<?php

namespace Xen3r0\JiraApiClient\Tests\Repository\Issue;

use Symfony\Contracts\HttpClient\ResponseInterface;
use Xen3r0\JiraApiClient\Http\JiraClientInterface;
use Xen3r0\JiraApiClient\Model\Issue\LinkType;
use Xen3r0\JiraApiClient\Repository\Issue\LinkTypeRepository;
use Xen3r0\JiraApiClient\Tests\Repository\AbstractRepositoryTestCase;

class LinkTypeRepositoryTest extends AbstractRepositoryTestCase
{
    public function testFindAll(): void
    {
        $content = $this->getFixtureContent('Issue/get_link_types.json');
        $jiraClient = $this->createMock(JiraClientInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $jiraClient
            ->expects($this->once())
            ->method('get')
            ->with('issueLinkType')
            ->willReturn($response);

        $response
            ->expects($this->once())
            ->method('getContent')
            ->willReturn($content);

        $repository = new LinkTypeRepository($jiraClient);
        $actual = $repository->findAll();

        $this->assertCount(2, $actual);
        $this->assertEquals('Blocks', $actual[0]->getName());
        $this->assertEquals('Cloners', $actual[1]->getName());
    }

    public function testFindById(): void
    {
        $content = $this->getFixtureContent('Issue/get_link_type.json');
        $jiraClient = $this->createMock(JiraClientInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $jiraClient
            ->expects($this->once())
            ->method('get')
            ->with('issueLinkType/10000')
            ->willReturn($response);

        $response
            ->expects($this->once())
            ->method('getContent')
            ->willReturn($content);

        $repository = new LinkTypeRepository($jiraClient);
        $actual = $repository->findById('10000');

        $this->assertInstanceOf(LinkType::class, $actual);
        $this->assertEquals('Blocks', $actual->getName());
    }
}
