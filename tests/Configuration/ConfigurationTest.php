<?php

namespace Xen3r0\JiraApiClient\Tests\Configuration;

use PHPUnit\Framework\TestCase;
use Xen3r0\JiraApiClient\Configuration\Configuration;

class ConfigurationTest extends TestCase
{
    public function testConstructorAndGetters(): void
    {
        $configuration = new Configuration('https://example.atlassian.net');

        $this->assertEquals('https://example.atlassian.net', $configuration->getHost());
        $this->assertNull($configuration->getUsername());
        $this->assertNull($configuration->getPassword());
        $this->assertNull($configuration->getToken());
    }

    public function testSetters(): void
    {
        $configuration = (new Configuration('https://example.atlassian.net'))
            ->setHost('https://workspace.atlassian.net')
            ->setUsername('john.doe@example.com')
            ->setPassword('secret')
            ->setToken('my-bearer-token');

        $this->assertEquals('https://workspace.atlassian.net', $configuration->getHost());
        $this->assertEquals('john.doe@example.com', $configuration->getUsername());
        $this->assertEquals('secret', $configuration->getPassword());
        $this->assertEquals('my-bearer-token', $configuration->getToken());
    }

    public function testCreateWithBasic(): void
    {
        $configuration = Configuration::createWithBasic('https://example.atlassian.net', 'john.doe@example.com', 'secret');

        $this->assertEquals('https://example.atlassian.net', $configuration->getHost());
        $this->assertEquals('john.doe@example.com', $configuration->getUsername());
        $this->assertEquals('secret', $configuration->getPassword());
        $this->assertNull($configuration->getToken());
    }

    public function testCreateWithToken(): void
    {
        $configuration = Configuration::createWithToken('https://example.atlassian.net', 'my-bearer-token');

        $this->assertEquals('https://example.atlassian.net', $configuration->getHost());
        $this->assertEquals('my-bearer-token', $configuration->getToken());
        $this->assertNull($configuration->getUsername());
        $this->assertNull($configuration->getPassword());
    }
}
