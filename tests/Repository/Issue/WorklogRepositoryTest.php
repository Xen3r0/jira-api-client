<?php

namespace Xen3r0\JiraApiClient\Tests\Repository\Issue;

use Symfony\Contracts\HttpClient\ResponseInterface;
use Xen3r0\Adf\Node\Block\Document;
use Xen3r0\JiraApiClient\Exception\Issue\WorklogMustBeExistsException;
use Xen3r0\JiraApiClient\Http\JiraClientInterface;
use Xen3r0\JiraApiClient\Model\Issue\Worklog;
use Xen3r0\JiraApiClient\Repository\Issue\WorklogRepository;
use Xen3r0\JiraApiClient\Serializer\SerializerFactory;
use Xen3r0\JiraApiClient\Tests\Repository\AbstractRepositoryTestCase;

class WorklogRepositoryTest extends AbstractRepositoryTestCase
{
    public function testFindAll(): void
    {
        $content = $this->getFixtureContent('Issue/get_worklogs.json');
        $jiraClient = $this->createMock(JiraClientInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $jiraClient
            ->expects($this->once())
            ->method('get')
            ->with(
                'issue/TEST-1/worklog',
                [
                    'query' => [
                        'startAt' => 0,
                        'maxResults' => 50,
                    ],
                ]
            )
            ->willReturn($response);

        $response
            ->expects($this->once())
            ->method('getContent')
            ->willReturn($content);

        $repository = new WorklogRepository($jiraClient);
        $actual = $repository->findAll('TEST-1');
        $this->assertNotEmpty($actual->getWorklogs());
    }

    public function testFindById(): void
    {
        $content = $this->getFixtureContent('Issue/get_worklog.json');
        $jiraClient = $this->createMock(JiraClientInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $jiraClient
            ->expects($this->once())
            ->method('get')
            ->with('issue/TEST-1/worklog/100028')
            ->willReturn($response);

        $response
            ->expects($this->once())
            ->method('getContent')
            ->willReturn($content);

        $repository = new WorklogRepository($jiraClient);
        $actual = $repository->findById('TEST-1', '100028');

        $this->assertInstanceOf(Worklog::class, $actual);
        $this->assertSame('100028', $actual->getId());
        $this->assertSame('3h 20m', $actual->getTimeSpent());
        $this->assertInstanceOf(Document::class, $actual->getComment());
    }

    public function testAdd(): void
    {
        $comment = Document::load([
            'type' => 'doc',
            'version' => 1,
            'content' => [
                ['type' => 'paragraph', 'content' => [['type' => 'text', 'text' => 'Worked on it']]],
            ],
        ]);

        $worklog = (new Worklog())
            ->setComment($comment)
            ->setStarted(new \DateTimeImmutable('2025-07-07T09:00:00+02:00'))
            ->setTimeSpent('1h');
        $payload = SerializerFactory::create()->serialize($worklog, 'json', ['groups' => Worklog::WRITE_GROUP]);

        $jiraClient = $this->createMock(JiraClientInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $jiraClient
            ->expects($this->once())
            ->method('post')
            ->with('issue/TEST-1/worklog', $payload)
            ->willReturn($response);

        $response
            ->expects($this->once())
            ->method('getContent')
            ->willReturn((string) json_encode(['id' => '100029']));

        $repository = new WorklogRepository($jiraClient);
        $actual = $repository->add('TEST-1', $worklog);

        $this->assertInstanceOf(Worklog::class, $actual);
        $this->assertEquals('100029', $actual->getId());
    }

    public function testUpdate(): void
    {
        $worklog = (new Worklog())
            ->setId('100028')
            ->setTimeSpent('2h');
        $payload = SerializerFactory::create()->serialize($worklog, 'json', ['groups' => Worklog::WRITE_GROUP]);

        $jiraClient = $this->createMock(JiraClientInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $jiraClient
            ->expects($this->once())
            ->method('put')
            ->with('issue/TEST-1/worklog/100028', $payload)
            ->willReturn($response);

        $response
            ->expects($this->once())
            ->method('getContent')
            ->willReturn((string) json_encode(['id' => '100028', 'timeSpent' => '2h']));

        $repository = new WorklogRepository($jiraClient);
        $actual = $repository->update('TEST-1', $worklog);

        $this->assertInstanceOf(Worklog::class, $actual);
        $this->assertEquals('2h', $actual->getTimeSpent());
    }

    public function testUpdateThrowsWhenWorklogHasNoId(): void
    {
        $worklog = (new Worklog())->setTimeSpent('2h');
        $jiraClient = $this->createMock(JiraClientInterface::class);

        $this->expectException(WorklogMustBeExistsException::class);

        $repository = new WorklogRepository($jiraClient);
        $repository->update('TEST-1', $worklog);
    }

    public function testRemove(): void
    {
        $jiraClient = $this->createMock(JiraClientInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $jiraClient
            ->expects($this->once())
            ->method('delete')
            ->with('issue/TEST-1/worklog/100028')
            ->willReturn($response);

        $repository = new WorklogRepository($jiraClient);
        $repository->remove('TEST-1', '100028');
    }
}
