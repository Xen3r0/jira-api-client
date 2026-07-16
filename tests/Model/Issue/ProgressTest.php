<?php

namespace Xen3r0\JiraApiClient\Tests\Model\Issue;

use PHPUnit\Framework\TestCase;
use Xen3r0\JiraApiClient\Model\Issue\Progress;

class ProgressTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $progress = (new Progress())
            ->setProgress(5)
            ->setTotal(10);

        $this->assertEquals(5, $progress->getProgress());
        $this->assertEquals(10, $progress->getTotal());
    }
}
