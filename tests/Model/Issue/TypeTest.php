<?php

namespace Xen3r0\JiraApiClient\Tests\Model\Issue;

use PHPUnit\Framework\TestCase;
use Xen3r0\JiraApiClient\Model\Issue\Type;

class TypeTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $type = (new Type())
            ->setId('10001')
            ->setName('Bug')
            ->setDescription('A problem which impairs or prevents the functions of the product.')
            ->setAvatarId(10303)
            ->setHierarchyLevel(0)
            ->setIconUrl('https://example.atlassian.net/images/icons/issuetypes/bug.svg')
            ->setSubtask(false)
            ->setSelf('https://example.atlassian.net/rest/api/3/issuetype/10001');

        $this->assertEquals('10001', $type->getId());
        $this->assertEquals('Bug', $type->getName());
        $this->assertEquals('A problem which impairs or prevents the functions of the product.', $type->getDescription());
        $this->assertEquals(10303, $type->getAvatarId());
        $this->assertEquals(0, $type->getHierarchyLevel());
        $this->assertEquals('https://example.atlassian.net/images/icons/issuetypes/bug.svg', $type->getIconUrl());
        $this->assertFalse($type->getSubtask());
        $this->assertEquals('https://example.atlassian.net/rest/api/3/issuetype/10001', $type->getSelf());
    }
}
