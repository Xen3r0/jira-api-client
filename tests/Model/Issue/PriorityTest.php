<?php

namespace Xen3r0\JiraApiClient\Tests\Model\Issue;

use PHPUnit\Framework\TestCase;
use Xen3r0\JiraApiClient\Model\Issue\Priority;

class PriorityTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $priority = (new Priority())
            ->setId('1')
            ->setName('Highest')
            ->setDescription('This problem will block progress.')
            ->setIconUrl('https://example.atlassian.net/images/icons/priorities/highest.svg')
            ->setSelf('https://example.atlassian.net/rest/api/3/priority/1');

        $this->assertEquals('1', $priority->getId());
        $this->assertEquals('Highest', $priority->getName());
        $this->assertEquals('This problem will block progress.', $priority->getDescription());
        $this->assertEquals('https://example.atlassian.net/images/icons/priorities/highest.svg', $priority->getIconUrl());
        $this->assertEquals('https://example.atlassian.net/rest/api/3/priority/1', $priority->getSelf());
    }
}
