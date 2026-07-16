<?php

namespace Xen3r0\JiraApiClient\Tests\Model\Issue;

use PHPUnit\Framework\TestCase;
use Xen3r0\JiraApiClient\Model\Issue\Comment;
use Xen3r0\JiraApiClient\Model\Issue\CommentSearchResult;

class CommentSearchResultTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $comment = (new Comment())->setId('10000');

        $result = (new CommentSearchResult())
            ->setMaxResults(100)
            ->setStartAt(0)
            ->setTotal(1)
            ->setComments([$comment]);

        $this->assertEquals(100, $result->getMaxResults());
        $this->assertEquals(0, $result->getStartAt());
        $this->assertEquals(1, $result->getTotal());
        $this->assertSame([$comment], $result->getComments());
    }
}
