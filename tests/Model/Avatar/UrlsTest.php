<?php

namespace Xen3r0\JiraApiClient\Tests\Model\Avatar;

use PHPUnit\Framework\TestCase;
use Xen3r0\JiraApiClient\Model\Avatar\Urls;

class UrlsTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $urls = (new Urls())
            ->setX16('https://example.atlassian.net/avatar/16.png')
            ->setX24('https://example.atlassian.net/avatar/24.png')
            ->setX32('https://example.atlassian.net/avatar/32.png')
            ->setX48('https://example.atlassian.net/avatar/48.png');

        $this->assertEquals('https://example.atlassian.net/avatar/16.png', $urls->getX16());
        $this->assertEquals('https://example.atlassian.net/avatar/24.png', $urls->getX24());
        $this->assertEquals('https://example.atlassian.net/avatar/32.png', $urls->getX32());
        $this->assertEquals('https://example.atlassian.net/avatar/48.png', $urls->getX48());
    }
}
