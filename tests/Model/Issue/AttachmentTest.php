<?php

namespace Xen3r0\JiraApiClient\Tests\Model\Issue;

use PHPUnit\Framework\TestCase;
use Xen3r0\JiraApiClient\Model\Issue\Attachment;
use Xen3r0\JiraApiClient\Model\User\User;

class AttachmentTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $author = (new User())->setDisplayName('John Doe');
        $created = new \DateTimeImmutable('2025-08-18T10:00:00+00:00');

        $attachment = (new Attachment())
            ->setId('10000')
            ->setSelf('https://example.atlassian.net/rest/api/3/attachment/10000')
            ->setFilename('picture.jpg')
            ->setAuthor($author)
            ->setCreated($created)
            ->setSize(23123)
            ->setMimeType('image/jpeg')
            ->setContent('https://example.atlassian.net/rest/api/3/attachment/content/10000')
            ->setThumbnail('https://example.atlassian.net/rest/api/3/attachment/thumbnail/10000');

        $this->assertEquals('10000', $attachment->getId());
        $this->assertEquals('https://example.atlassian.net/rest/api/3/attachment/10000', $attachment->getSelf());
        $this->assertEquals('picture.jpg', $attachment->getFilename());
        $this->assertSame($author, $attachment->getAuthor());
        $this->assertEquals($created, $attachment->getCreated());
        $this->assertEquals(23123, $attachment->getSize());
        $this->assertEquals('image/jpeg', $attachment->getMimeType());
        $this->assertEquals('https://example.atlassian.net/rest/api/3/attachment/content/10000', $attachment->getContent());
        $this->assertEquals('https://example.atlassian.net/rest/api/3/attachment/thumbnail/10000', $attachment->getThumbnail());
    }
}
