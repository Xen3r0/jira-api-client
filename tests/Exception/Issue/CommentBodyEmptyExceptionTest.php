<?php

namespace Xen3r0\JiraApiClient\Tests\Exception\Issue;

use PHPUnit\Framework\TestCase;
use Xen3r0\JiraApiClient\Exception\Issue\CommentBodyEmptyException;

class CommentBodyEmptyExceptionTest extends TestCase
{
    public function testMessage(): void
    {
        $exception = new CommentBodyEmptyException();

        $this->assertEquals('The comment body cannot be empty.', $exception->getMessage());
        $this->assertEquals(0, $exception->getCode());
        $this->assertNull($exception->getPrevious());
    }

    public function testCodeAndPreviousAreForwarded(): void
    {
        $previous = new \RuntimeException('previous');

        $exception = new CommentBodyEmptyException(42, $previous);

        $this->assertEquals('The comment body cannot be empty.', $exception->getMessage());
        $this->assertEquals(42, $exception->getCode());
        $this->assertSame($previous, $exception->getPrevious());
    }
}
