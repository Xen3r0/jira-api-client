<?php

namespace Xen3r0\JiraApiClient\Tests\Symfony\Bundle\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\Config\Definition\Processor;
use Xen3r0\JiraApiClient\Symfony\Bundle\DependencyInjection\Configuration;

class ConfigurationTest extends TestCase
{
    public function testDefaults(): void
    {
        $config = (new Processor())->processConfiguration(
            new Configuration(),
            [
                [
                    'http' => [
                        'host' => 'https://example.atlassian.net',
                    ],
                ],
            ]
        );

        $this->assertEquals('https://example.atlassian.net', $config['http']['host']);
        $this->assertNull($config['http']['username']);
        $this->assertNull($config['http']['password']);
    }

    public function testHostIsRequired(): void
    {
        $this->expectException(InvalidConfigurationException::class);

        (new Processor())->processConfiguration(
            new Configuration(),
            [
                [
                    'http' => [],
                ],
            ]
        );
    }
}
