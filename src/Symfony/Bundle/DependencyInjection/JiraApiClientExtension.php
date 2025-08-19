<?php

namespace Xen3r0\JiraApiClient\Symfony\Bundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Xen3r0\JiraApiClient\Configuration\ConfigurationInterface as JiraApiClientConfigurationInterface;

class JiraApiClientExtension extends Extension
{
    /**
     * @param array<string, mixed> $config
     */
    public function getConfiguration(array $config, ContainerBuilder $container): ?ConfigurationInterface
    {
        return new Configuration();
    }

    /**
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        /** @var Configuration $configuration */
        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new PhpFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $container->setParameter('jira_api_client.http.host', $config['http']['host']);
        $container->setParameter('jira_api_client.http.username', $config['http']['username']);
        $container->setParameter('jira_api_client.http.password', $config['http']['password']);

        $loader->load('configuration.php');
        $loader->load('http.php');
        $loader->load('normalizers.php');
        $loader->load('repositories.php');

        if (isset($config['http']['username']) && isset($config['http']['password'])) {
            $container->getDefinition(JiraApiClientConfigurationInterface::class)
                ->addMethodCall('setUsername', [$config['http']['username']])
                ->addMethodCall('setPassword', [$config['http']['password']]);
        }
    }
}
