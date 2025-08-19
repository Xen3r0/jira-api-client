<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Xen3r0\JiraApiClient\Configuration\Configuration;
use Xen3r0\JiraApiClient\Configuration\ConfigurationInterface;

return static function (ContainerConfigurator $container) {
    $container->services()
        ->set(ConfigurationInterface::class, Configuration::class)
            ->args([
                param('jira_api_client.http.host'),
            ]);
};
