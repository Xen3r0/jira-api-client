<?php

namespace Xen3r0\JiraApiClient\Tests\Model\Issue;

use PHPUnit\Framework\TestCase;
use Xen3r0\JiraApiClient\Model\Issue\LinkType;

class LinkTypeTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $linkType = (new LinkType())
            ->setId('10000')
            ->setName('Blocks')
            ->setInward('is blocked by')
            ->setOutward('blocks')
            ->setSelf('https://example.atlassian.net/rest/api/3/issueLinkType/10000');

        $this->assertEquals('10000', $linkType->getId());
        $this->assertEquals('Blocks', $linkType->getName());
        $this->assertEquals('is blocked by', $linkType->getInward());
        $this->assertEquals('blocks', $linkType->getOutward());
        $this->assertEquals('https://example.atlassian.net/rest/api/3/issueLinkType/10000', $linkType->getSelf());
    }
}
