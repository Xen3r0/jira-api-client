<?php

namespace Xen3r0\JiraApiClient\Tests\Model\Issue;

use PHPUnit\Framework\TestCase;
use Xen3r0\Adf\Node\Block\Document;
use Xen3r0\JiraApiClient\Model\Issue\Comment;
use Xen3r0\JiraApiClient\Model\Issue\Visiblity;
use Xen3r0\JiraApiClient\Model\User\User;

class CommentTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $author = (new User())->setDisplayName('John Doe');
        $updateAuthor = (new User())->setDisplayName('Jane Doe');
        $created = new \DateTimeImmutable('2025-08-18T10:00:00+00:00');
        $updated = new \DateTimeImmutable('2025-08-19T10:00:00+00:00');
        $body = new Document();
        $visiblity = (new Visiblity())->setType('role')->setValue('Administrators');

        $comment = (new Comment())
            ->setId('10000')
            ->setAuthor($author)
            ->setCreated($created)
            ->setUpdateAuthor($updateAuthor)
            ->setUpdated($updated)
            ->setBody($body)
            ->setRenderedBody('<p>Hello world</p>')
            ->setJsdAuthorCanSeeRequest(true)
            ->setJsdPublic(true)
            ->setProperties(['sd.public.comment' => ['internal' => false]])
            ->setVisiblity($visiblity)
            ->setSelf('https://example.atlassian.net/rest/api/3/issue/TEST-1/comment/10000');

        $this->assertEquals('10000', $comment->getId());
        $this->assertSame($author, $comment->getAuthor());
        $this->assertEquals($created, $comment->getCreated());
        $this->assertSame($updateAuthor, $comment->getUpdateAuthor());
        $this->assertEquals($updated, $comment->getUpdated());
        $this->assertSame($body, $comment->getBody());
        $this->assertEquals('<p>Hello world</p>', $comment->getRenderedBody());
        $this->assertTrue($comment->isJsdAuthorCanSeeRequest());
        $this->assertTrue($comment->isJsdPublic());
        $this->assertEquals(['sd.public.comment' => ['internal' => false]], $comment->getProperties());
        $this->assertSame($visiblity, $comment->getVisiblity());
        $this->assertEquals('https://example.atlassian.net/rest/api/3/issue/TEST-1/comment/10000', $comment->getSelf());
    }
}
