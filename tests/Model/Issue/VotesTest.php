<?php

namespace Xen3r0\JiraApiClient\Tests\Model\Issue;

use PHPUnit\Framework\TestCase;
use Xen3r0\JiraApiClient\Model\Issue\Votes;
use Xen3r0\JiraApiClient\Model\User\User;

class VotesTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $voter = (new User())->setDisplayName('John Doe');

        $votes = (new Votes())
            ->setHasVoted(true)
            ->setVotes(3)
            ->setVoters([$voter])
            ->setSelf('https://example.atlassian.net/rest/api/3/issue/TEST-1/votes');

        $this->assertTrue($votes->isHasVoted());
        $this->assertEquals(3, $votes->getVotes());
        $this->assertSame([$voter], $votes->getVoters());
        $this->assertEquals('https://example.atlassian.net/rest/api/3/issue/TEST-1/votes', $votes->getSelf());
    }
}
