<?php

namespace Xen3r0\JiraApiClient\Tests\Model\Issue;

use PHPUnit\Framework\TestCase;
use Xen3r0\JiraApiClient\Model\Issue\LinkType;
use Xen3r0\JiraApiClient\Model\Issue\LinkTypeSearchResult;

class LinkTypeSearchResultTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $linkType = (new LinkType())->setId('10000')->setName('Blocks');

        $result = (new LinkTypeSearchResult())->setIssueLinkTypes([$linkType]);

        $this->assertSame([$linkType], $result->getIssueLinkTypes());
    }
}
