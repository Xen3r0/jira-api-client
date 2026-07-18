<?php

namespace Xen3r0\JiraApiClient\Tests\Repository\Issue;

use Symfony\Contracts\HttpClient\ResponseInterface;
use Xen3r0\Adf\Node\Block\Document;
use Xen3r0\Adf\Node\Block\Paragraph;
use Xen3r0\Adf\Node\Inline\Text;
use Xen3r0\Adf\Node\Mark\Strong;
use Xen3r0\JiraApiClient\Exception\Issue\IssueMustBeExistsException;
use Xen3r0\JiraApiClient\Http\JiraClientInterface;
use Xen3r0\JiraApiClient\Model\Issue\Issue;
use Xen3r0\JiraApiClient\Model\Issue\Type;
use Xen3r0\JiraApiClient\Model\Project\Project;
use Xen3r0\JiraApiClient\Repository\Issue\IssueRepository;
use Xen3r0\JiraApiClient\Tests\Repository\AbstractRepositoryTestCase;

class IssueRepositoryTest extends AbstractRepositoryTestCase
{
    public function testFindAll(): void
    {
        $content = $this->getFixtureContent('Issue/post_issue_search_jql.json');
        $jiraClient = $this->createMock(JiraClientInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $jiraClient
            ->expects($this->once())
            ->method('post')
            ->with(
                'search/jql',
                [
                    'jql' => 'project = QA',
                    'maxResults' => 15,
                    'fields' => ['*all'],
                    'expand' => '',
                    'nextPageToken' => null,
                ]
            )
            ->willReturn($response);

        $response
            ->expects($this->once())
            ->method('getContent')
            ->willReturn($content);

        $repository = new IssueRepository($jiraClient);
        $actual = $repository->findAll('project = QA');
        $this->assertNotEmpty($actual->getIssues());
    }

    public function testFindAllWithExplicitFields(): void
    {
        $content = $this->getFixtureContent('Issue/post_issue_search_jql.json');
        $jiraClient = $this->createMock(JiraClientInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $jiraClient
            ->expects($this->once())
            ->method('post')
            ->with(
                'search/jql',
                [
                    'jql' => 'project = QA',
                    'maxResults' => 15,
                    'fields' => ['summary', 'status'],
                    'expand' => '',
                    'nextPageToken' => null,
                ]
            )
            ->willReturn($response);

        $response
            ->expects($this->once())
            ->method('getContent')
            ->willReturn($content);

        $repository = new IssueRepository($jiraClient);
        $actual = $repository->findAll('project = QA', 15, null, ['summary', 'status']);
        $this->assertNotEmpty($actual->getIssues());
    }

    public function testFindByIdOrKey(): void
    {
        $content = $this->getFixtureContent('Issue/get_issue.json');
        $jiraClient = $this->createMock(JiraClientInterface::class);
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

        $description = $actual->getFields()->getDescription();
        $this->assertInstanceOf(Document::class, $description);

        $paragraph = $description->getContent()[0];
        $this->assertInstanceOf(Paragraph::class, $paragraph);

        $firstText = $paragraph->getContent()[0];
        $this->assertInstanceOf(Text::class, $firstText);
        $this->assertSame('Hello ', $firstText->getText());

        $secondText = $paragraph->getContent()[1];
        $this->assertInstanceOf(Text::class, $secondText);
        $this->assertSame('world', $secondText->getText());
        $this->assertInstanceOf(Strong::class, $secondText->getMarks()[0]);

        $this->assertNotEmpty($actual->getFields()->getCustomFields());
        $this->assertArrayHasKey('customfield_10072', $actual->getFields()->getCustomFields());
        $this->assertArrayHasKey('customfield_10073', $actual->getFields()->getCustomFields());
        $this->assertArrayHasKey('customfield_10061', $actual->getFields()->getCustomFields());
        $this->assertArrayHasKey('customfield_10067', $actual->getFields()->getCustomFields());
    }

    public function testCreate(): void
    {
        $issue = new Issue();
        $issue->getFields()
            ->setSummary('Something is broken')
            ->setProject((new Project())->setKey('QA'))
            ->setIssueType((new Type())->setId('10001'));

        $payload = json_encode([
            'fields' => [
                'summary' => 'Something is broken',
                'labels' => [],
                'issuetype' => ['id' => '10001'],
                'project' => ['key' => 'QA'],
            ],
        ]);
        $this->assertIsString($payload);

        $content = $this->getFixtureContent('Issue/post_issue.json');
        $jiraClient = $this->createMock(JiraClientInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $jiraClient
            ->expects($this->once())
            ->method('post')
            ->with('issue', $payload)
            ->willReturn($response);

        $response
            ->expects($this->once())
            ->method('getContent')
            ->willReturn($content);

        $repository = new IssueRepository($jiraClient);
        $actual = $repository->create($issue);

        $this->assertInstanceOf(Issue::class, $actual);
        $this->assertEquals('24812', $actual->id);
        $this->assertEquals('QA-6921', $actual->key);
    }

    public function testUpdate(): void
    {
        $issue = new Issue();
        $issue->key = 'QA-6921';
        $issue->getFields()->setSummary('Updated summary');

        $payload = json_encode(['fields' => ['summary' => 'Updated summary', 'labels' => []]]);
        $this->assertIsString($payload);

        $jiraClient = $this->createMock(JiraClientInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $jiraClient
            ->expects($this->once())
            ->method('put')
            ->with('issue/QA-6921', $payload)
            ->willReturn($response);

        $repository = new IssueRepository($jiraClient);
        $repository->update($issue);
    }

    public function testUpdateOnIssueWithoutIdOrKey(): void
    {
        $issue = new Issue();
        $issue->getFields()->setSummary('Updated summary');

        $jiraClient = $this->createMock(JiraClientInterface::class);

        $this->expectException(IssueMustBeExistsException::class);

        $repository = new IssueRepository($jiraClient);
        $repository->update($issue);
    }

    public function testDelete(): void
    {
        $jiraClient = $this->createMock(JiraClientInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $jiraClient
            ->expects($this->once())
            ->method('delete')
            ->with('issue/QA-6921')
            ->willReturn($response);

        $repository = new IssueRepository($jiraClient);
        $repository->delete('QA-6921');
    }
}
