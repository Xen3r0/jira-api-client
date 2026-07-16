<?php

namespace Xen3r0\JiraApiClient\Tests\Model\Issue;

use PHPUnit\Framework\TestCase;
use Xen3r0\JiraApiClient\Model\Issue\Resolution;

class ResolutionTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $resolution = (new Resolution())
            ->setId('10000')
            ->setName('Fixed')
            ->setDescription('A fix for this issue is committed.')
            ->setSelf('https://example.atlassian.net/rest/api/3/resolution/10000');

        $this->assertEquals('10000', $resolution->getId());
        $this->assertEquals('Fixed', $resolution->getName());
        $this->assertEquals('A fix for this issue is committed.', $resolution->getDescription());
        $this->assertEquals('https://example.atlassian.net/rest/api/3/resolution/10000', $resolution->getSelf());
    }
}
