<?php

namespace Xen3r0\JiraApiClient\Tests\Repository\Issue;

use DH\Adf\Node\Block\Document;
use DH\Adf\Node\Block\Paragraph;
use DH\Adf\Node\Inline\Mention;
use DH\Adf\Node\Inline\Text;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Xen3r0\JiraApiClient\Http\JiraClient;
use Xen3r0\JiraApiClient\Repository\Issue\IssueCommentRepository;
use Xen3r0\JiraApiClient\Tests\Repository\AbstractRepositoryTestCase;

class IssueCommentRepositoryTest extends AbstractRepositoryTestCase
{
    public function testFindAll(): void
    {
        $content = $this->getFixtureContent('Issue/get_comments.json');
        $jiraClient = $this->createMock(JiraClient::class);
        $response = $this->createMock(ResponseInterface::class);

        $jiraClient
            ->expects($this->once())
            ->method('get')
            ->with('issue/TEST-1/comment')
            ->willReturn($response);

        $response
            ->expects($this->once())
            ->method('getContent')
            ->willReturn($content);

        $repository = new IssueCommentRepository($jiraClient);
        $actual = $repository->findAll('TEST-1');
        $this->assertNotEmpty($actual->getComments());
    }

    public function testFindById(): void
    {
        $content = $this->getFixtureContent('Issue/get_comment.json');
        $jiraClient = $this->createMock(JiraClient::class);
        $response = $this->createMock(ResponseInterface::class);

        $jiraClient
            ->expects($this->once())
            ->method('get')
            ->with('issue/TEST-1/comment/123')
            ->willReturn($response);

        $response
            ->expects($this->once())
            ->method('getContent')
            ->willReturn($content);

        $repository = new IssueCommentRepository($jiraClient);
        $actual = $repository->findById('TEST-1', '123');

        $this->assertNotNull($actual);

        $this->assertInstanceOf(Document::class, $actual->getBody());
        $this->assertInstanceOf(Paragraph::class, $actual->getBody()->getContent()[0]);
        $this->assertInstanceOf(Mention::class, $actual->getBody()->getContent()[0]->getContent()[0]);
        $this->assertInstanceOf(Text::class, $actual->getBody()->getContent()[0]->getContent()[1]);
    }
}
