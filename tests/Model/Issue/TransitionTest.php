<?php

namespace Xen3r0\JiraApiClient\Tests\Model\Issue;

use PHPUnit\Framework\TestCase;
use Xen3r0\JiraApiClient\Model\Issue\Transition;
use Xen3r0\JiraApiClient\Model\Status\Status;

class TransitionTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $status = (new Status())->setId('3')->setName('In Progress');

        $transition = (new Transition())
            ->setId('11')
            ->setName('Start progress')
            ->setTo($status)
            ->setHasScreen(true)
            ->setIsAvailable(false);

        $this->assertEquals('11', $transition->getId());
        $this->assertEquals('Start progress', $transition->getName());
        $this->assertSame($status, $transition->getTo());
        $this->assertTrue($transition->getHasScreen());
        $this->assertFalse($transition->getIsAvailable());
    }
}
