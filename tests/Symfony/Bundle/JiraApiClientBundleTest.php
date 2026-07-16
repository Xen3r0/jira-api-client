<?php

namespace Xen3r0\JiraApiClient\Tests\Symfony\Bundle;

use PHPUnit\Framework\TestCase;
use Xen3r0\JiraApiClient\Symfony\Bundle\DependencyInjection\JiraApiClientExtension;
use Xen3r0\JiraApiClient\Symfony\Bundle\JiraApiClientBundle;

class JiraApiClientBundleTest extends TestCase
{
    public function testGetContainerExtension(): void
    {
        $bundle = new JiraApiClientBundle();

        $this->assertInstanceOf(JiraApiClientExtension::class, $bundle->getContainerExtension());
    }
}
