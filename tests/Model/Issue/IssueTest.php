<?php

namespace Xen3r0\JiraApiClient\Tests\Model\Issue;

use PHPUnit\Framework\TestCase;
use Xen3r0\JiraApiClient\Model\Issue\Fields;
use Xen3r0\JiraApiClient\Model\Issue\Issue;

class IssueTest extends TestCase
{
    public function testConstructorInitializesFields(): void
    {
        $issue = new Issue();

        $this->assertEquals(new Fields(), $issue->getFields());
    }

    public function testGettersAndSetters(): void
    {
        $fields = (new Fields())->setSummary('This is a bug');

        $issue = (new Issue())
            ->setExpand('renderedFields')
            ->setId('10000')
            ->setSelf('https://example.atlassian.net/rest/api/3/issue/10000')
            ->setKey('TEST-1')
            ->setFields($fields);

        $this->assertEquals('renderedFields', $issue->getExpand());
        $this->assertEquals('10000', $issue->getId());
        $this->assertEquals('https://example.atlassian.net/rest/api/3/issue/10000', $issue->getSelf());
        $this->assertEquals('TEST-1', $issue->getKey());
        $this->assertSame($fields, $issue->getFields());
    }
}
