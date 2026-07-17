<?php

namespace Xen3r0\JiraApiClient\Tests\Model\Issue;

use PHPUnit\Framework\TestCase;
use Xen3r0\JiraApiClient\Model\Issue\Transition;
use Xen3r0\JiraApiClient\Model\Issue\TransitionSearchResult;

class TransitionSearchResultTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $transition = (new Transition())->setId('11')->setName('Start progress');

        $result = (new TransitionSearchResult())
            ->setExpand('transitions')
            ->setTransitions([$transition]);

        $this->assertEquals('transitions', $result->getExpand());
        $this->assertSame([$transition], $result->getTransitions());
    }
}
