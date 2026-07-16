<?php

namespace Xen3r0\JiraApiClient\Tests\Model\Issue;

use PHPUnit\Framework\TestCase;
use Xen3r0\JiraApiClient\Model\Issue\Watches;

class WatchesTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $watches = (new Watches())
            ->setIsWatching(true)
            ->setWatchCount(3)
            ->setSelf('https://example.atlassian.net/rest/api/3/issue/TEST-1/watchers');

        $this->assertTrue($watches->isWatching());
        $this->assertEquals(3, $watches->getWatchCount());
        $this->assertEquals('https://example.atlassian.net/rest/api/3/issue/TEST-1/watchers', $watches->getSelf());
    }
}
