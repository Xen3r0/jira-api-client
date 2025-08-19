<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Xen3r0\JiraApiClient\Configuration\ConfigurationInterface;
use Xen3r0\JiraApiClient\Http\JiraClient;
use Xen3r0\JiraApiClient\Http\JiraClientInterface;

return static function (ContainerConfigurator $container) {
    $container->services()
        ->set(JiraClientInterface::class, JiraClient::class)
            ->args([
                service(ConfigurationInterface::class),
            ]);
};
