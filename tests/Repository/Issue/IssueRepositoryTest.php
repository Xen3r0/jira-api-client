<?php

namespace Xen3r0\JiraApiClient\Tests\Repository\Issue;

use DH\Adf\Node\Block\Document;
use DH\Adf\Node\Block\Paragraph;
use DH\Adf\Node\Inline\Text;
use DH\Adf\Node\Mark\Strong;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Xen3r0\JiraApiClient\Http\JiraClient;
use Xen3r0\JiraApiClient\Repository\Issue\IssueRepository;
use Xen3r0\JiraApiClient\Tests\Repository\AbstractRepositoryTestCase;

class IssueRepositoryTest extends AbstractRepositoryTestCase
{
    public function testFindAll(): void
    {
        $content = $this->getFixtureContent('Issue/post_issue_search_jql.json');
        $jiraClient = $this->createMock(JiraClient::class);
        $response = $this->createMock(ResponseInterface::class);

        $jiraClient
            ->expects($this->once())
            ->method('post')
            ->with('search/jql')
            ->willReturn($response);

        $response
            ->expects($this->once())
            ->method('getContent')
            ->willReturn($content);

        $repository = new IssueRepository($jiraClient);
        $actual = $repository->findAll('project = QA');
        $this->assertNotEmpty($actual->getIssues());
    }

    public function testFindByIdOrKey(): void
    {
        $content = $this->getFixtureContent('Issue/get_issue.json');
        $jiraClient = $this->createMock(JiraClient::class);
        $response = $this->createMock(ResponseInterface::class);

        $jiraClient
            ->expects($this->once())
            ->method('get')
            ->with('issue/TEST-1')
            ->willReturn($response);

        $response
            ->expects($this->once())
            ->method('getContent')
            ->willReturn($content);

        $repository = new IssueRepository($jiraClient);
        $actual = $repository->findByIdOrKey('TEST-1');

        $this->assertNotNull($actual);

        $this->assertInstanceOf(Document::class, $actual->getFields()->getDescription());
        $this->assertInstanceOf(Paragraph::class, $actual->getFields()->getDescription()->getContent()[0]);
        $this->assertInstanceOf(Text::class, $actual->getFields()->getDescription()->getContent()[0]->getContent()[0]);
        $this->assertSame('Hello ', $actual->getFields()->getDescription()->getContent()[0]->getContent()[0]->getText());
        $this->assertSame('world', $actual->getFields()->getDescription()->getContent()[0]->getContent()[1]->getText());
        $this->assertInstanceOf(Strong::class, $actual->getFields()->getDescription()->getContent()[0]->getContent()[1]->getMarks()[0]);

        $this->assertNotEmpty($actual->getFields()->getCustomFields());
        $this->assertArrayHasKey('customfield_10072', $actual->getFields()->getCustomFields());
        $this->assertArrayHasKey('customfield_10073', $actual->getFields()->getCustomFields());
        $this->assertArrayHasKey('customfield_10061', $actual->getFields()->getCustomFields());
        $this->assertArrayHasKey('customfield_10067', $actual->getFields()->getCustomFields());
    }
}
