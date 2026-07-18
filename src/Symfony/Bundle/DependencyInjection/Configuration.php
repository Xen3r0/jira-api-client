<?php

namespace Xen3r0\JiraApiClient\Symfony\Bundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('jira_api_client');

        /** @var ArrayNodeDefinition $rootNode */
        $rootNode = $treeBuilder->getRootNode();

        /* @phpstan-ignore-next-line */
        $rootNode
            ->children()
                ->arrayNode('http')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('host')
                            ->isRequired()
                            ->info('Host URL for Jira API.')
                        ->end()
                        ->scalarNode('username')
                            ->defaultNull()
                            ->info('Username for Jira API authentication.')
                        ->end()
                        ->scalarNode('password')
                            ->defaultNull()
                            ->info('Password for Jira API authentication.')
                        ->end()
                        ->scalarNode('token')
                            ->defaultNull()
                            ->info('Bearer token (API token / OAuth 2.0 access token) for Jira API authentication. Takes precedence over username/password when set.')
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
