<?php

namespace Xen3r0\JiraApiClient\Tests\Model\Issue;

use PHPUnit\Framework\TestCase;
use Xen3r0\JiraApiClient\Model\Issue\Visiblity;

class VisiblityTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $visiblity = (new Visiblity())
            ->setIdentifier('10000')
            ->setType('role')
            ->setValue('Administrators');

        $this->assertEquals('10000', $visiblity->getIdentifier());
        $this->assertEquals('role', $visiblity->getType());
        $this->assertEquals('Administrators', $visiblity->getValue());
    }
}
