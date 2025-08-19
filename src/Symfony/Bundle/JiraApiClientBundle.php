<?php

namespace Xen3r0\JiraApiClient\Symfony\Bundle;

use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Xen3r0\JiraApiClient\Symfony\Bundle\DependencyInjection\JiraApiClientExtension;

class JiraApiClientBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new JiraApiClientExtension();
    }
}
