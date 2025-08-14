<?php

namespace Xen3r0\JiraApiClient\Configuration;

class ConfigurationFactory
{
    /**
     * @param array{host: string, username: string|null, password: string|null} $config
     */
    public static function create(array $config): Configuration
    {
        $configuration = new Configuration($config['host']);

        if (isset($config['username'])) {
            $configuration->setUsername($config['username']);
        }

        if (isset($config['password'])) {
            $configuration->setPassword($config['password']);
        }

        return $configuration;
    }
}
