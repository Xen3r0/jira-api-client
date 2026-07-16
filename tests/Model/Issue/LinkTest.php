<?php

namespace Xen3r0\JiraApiClient\Tests\Model\Issue;

use PHPUnit\Framework\TestCase;
use Xen3r0\JiraApiClient\Model\Issue\Issue;
use Xen3r0\JiraApiClient\Model\Issue\Link;
use Xen3r0\JiraApiClient\Model\Issue\LinkType;

class LinkTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $inwardIssue = (new Issue())->setKey('TEST-1');
        $outwardIssue = (new Issue())->setKey('TEST-2');
        $type = (new LinkType())->setName('Blocks');

        $link = (new Link())
            ->setId('10000')
            ->setInwardIssue($inwardIssue)
            ->setOutwardIssue($outwardIssue)
            ->setType($type);

        $this->assertEquals('10000', $link->getId());
        $this->assertSame($inwardIssue, $link->getInwardIssue());
        $this->assertSame($outwardIssue, $link->getOutwardIssue());
        $this->assertSame($type, $link->getType());
    }
}
