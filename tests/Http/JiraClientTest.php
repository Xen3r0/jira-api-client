<?php

namespace Xen3r0\JiraApiClient\Tests\Http;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Xen3r0\JiraApiClient\Configuration\ConfigurationFactory;
use Xen3r0\JiraApiClient\Configuration\ConfigurationInterface;
use Xen3r0\JiraApiClient\Http\JiraClient;

class JiraClientTest extends TestCase
{
    private ConfigurationInterface $configuration;

    private MockHttpClient $httpClient;

    protected function setUp(): void
    {
        parent::setUp();
        $this->configuration = ConfigurationFactory::create([
            'host' => 'https://workspace.atlassian.net',
            'username' => 'account@compagny.fr',
            'password' => 'mytoken',
        ]);
        $this->httpClient = new MockHttpClient();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset(
            $this->configuration,
            $this->httpClient,
        );
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testGet(): void
    {
        $json = ['key' => 'QA-123', 'fields' => ['summary' => 'Test issue']];
        $response = function ($method, $url, $options) use ($json): MockResponse {
            $this->assertSame('GET', $method);
            $this->assertSame('https://workspace.atlassian.net/rest/api/3/issue/QA-123', $url);

            $json = json_encode($json);
            $this->assertIsString($json);

            return new MockResponse($json);
        };
        $httpClient = new MockHttpClient($response);

        $jiraClient = new JiraClient($this->configuration, $httpClient);
        $actual = $jiraClient->get('issue/QA-123');
        $this->assertSame($json, $actual->toArray());
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testPost(): void
    {
        $json = ['key' => 'QA-123', 'fields' => ['summary' => 'Test issue']];
        $response = function ($method, $url, $options): MockResponse {
            $this->assertSame('POST', $method);
            $this->assertSame('https://workspace.atlassian.net/rest/api/3/issue', $url);

            return new MockResponse();
        };
        $httpClient = new MockHttpClient($response);

        $jiraClient = new JiraClient($this->configuration, $httpClient);
        $jiraClient->post('issue', $json);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testPut(): void
    {
        $json = ['key' => 'QA-123', 'fields' => ['summary' => 'Test issue']];
        $response = function ($method, $url, $options): MockResponse {
            $this->assertSame('PUT', $method);
            $this->assertSame('https://workspace.atlassian.net/rest/api/3/issue/QA-123', $url);

            return new MockResponse();
        };
        $httpClient = new MockHttpClient($response);

        $jiraClient = new JiraClient($this->configuration, $httpClient);
        $jiraClient->put('issue/QA-123', $json);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testDelete(): void
    {
        $response = function ($method, $url, $options): MockResponse {
            $this->assertSame('DELETE', $method);
            $this->assertSame('https://workspace.atlassian.net/rest/api/3/issue/QA-123', $url);

            return new MockResponse();
        };
        $httpClient = new MockHttpClient($response);

        $jiraClient = new JiraClient($this->configuration, $httpClient);
        $jiraClient->delete('issue/QA-123');
    }
}
