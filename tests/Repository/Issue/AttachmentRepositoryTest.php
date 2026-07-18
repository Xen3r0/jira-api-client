<?php

namespace Xen3r0\JiraApiClient\Tests\Repository\Issue;

use Symfony\Contracts\HttpClient\ResponseInterface;
use Xen3r0\JiraApiClient\Http\JiraClientInterface;
use Xen3r0\JiraApiClient\Model\Issue\Attachment;
use Xen3r0\JiraApiClient\Repository\Issue\AttachmentRepository;
use Xen3r0\JiraApiClient\Tests\Repository\AbstractRepositoryTestCase;

class AttachmentRepositoryTest extends AbstractRepositoryTestCase
{
    public function testAdd(): void
    {
        $tmpFile = tempnam(sys_get_temp_dir(), 'jac_test_').'.pdf';
        file_put_contents($tmpFile, 'file content');

        $content = $this->getFixtureContent('Issue/post_attachments.json');
        $jiraClient = $this->createMock(JiraClientInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $jiraClient
            ->expects($this->once())
            ->method('postMultipart')
            ->with(
                'issue/TEST-1/attachments',
                $this->callback(static fn (array $formData): bool => isset($formData['file']) && is_resource($formData['file']))
            )
            ->willReturn($response);

        $response
            ->expects($this->once())
            ->method('getContent')
            ->willReturn($content);

        $repository = new AttachmentRepository($jiraClient);
        $actual = $repository->add('TEST-1', $tmpFile);

        $this->assertCount(1, $actual);
        $this->assertInstanceOf(Attachment::class, $actual[0]);
        $this->assertSame('10001', $actual[0]->getId());
        $this->assertSame('report.pdf', $actual[0]->getFilename());

        unlink($tmpFile);
    }

    public function testAddThrowsWhenFileIsNotReadable(): void
    {
        $jiraClient = $this->createMock(JiraClientInterface::class);
        $jiraClient->expects($this->never())->method('postMultipart');

        $this->expectException(\InvalidArgumentException::class);

        $repository = new AttachmentRepository($jiraClient);
        $repository->add('TEST-1', '/nonexistent/path/to/file.pdf');
    }

    public function testFindById(): void
    {
        $content = $this->getFixtureContent('Issue/get_attachment.json');
        $jiraClient = $this->createMock(JiraClientInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $jiraClient
            ->expects($this->once())
            ->method('get')
            ->with('attachment/10000')
            ->willReturn($response);

        $response
            ->expects($this->once())
            ->method('getContent')
            ->willReturn($content);

        $repository = new AttachmentRepository($jiraClient);
        $actual = $repository->findById('10000');

        $this->assertInstanceOf(Attachment::class, $actual);
        $this->assertSame('10000', $actual->getId());
        $this->assertSame('picture.jpg', $actual->getFilename());
        $this->assertSame('image/jpeg', $actual->getMimeType());
    }

    public function testRemove(): void
    {
        $jiraClient = $this->createMock(JiraClientInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $jiraClient
            ->expects($this->once())
            ->method('delete')
            ->with('attachment/10000')
            ->willReturn($response);

        $repository = new AttachmentRepository($jiraClient);
        $repository->remove('10000');
    }

    public function testGetContent(): void
    {
        $jiraClient = $this->createMock(JiraClientInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $jiraClient
            ->expects($this->once())
            ->method('get')
            ->with('attachment/content/10000')
            ->willReturn($response);

        $response
            ->expects($this->once())
            ->method('getContent')
            ->willReturn('binary file content');

        $repository = new AttachmentRepository($jiraClient);
        $actual = $repository->getContent('10000');

        $this->assertSame('binary file content', $actual);
    }
}
