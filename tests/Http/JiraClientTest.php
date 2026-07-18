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
use Xen3r0\JiraApiClient\Enum\Http\Method;
use Xen3r0\JiraApiClient\Exception\Http\JiraApiException;
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
    public function testPostMultipartSendsFileAsMultipartFormData(): void
    {
        $tmpFile = tempnam(sys_get_temp_dir(), 'jac_test_').'.txt';
        file_put_contents($tmpFile, 'file content');

        $response = function ($method, $url, $options) use ($tmpFile): MockResponse {
            $this->assertSame(Method::Post->value, $method);
            $this->assertSame('https://workspace.atlassian.net/rest/api/3/issue/QA-123/attachments', $url);

            $hasMultipartContentType = false;
            foreach ($options['headers'] as $header) {
                if (str_starts_with($header, 'Content-Type: multipart/form-data')) {
                    $hasMultipartContentType = true;
                }
            }
            $this->assertTrue($hasMultipartContentType);

            $body = $options['body'];
            $this->assertInstanceOf(\Closure::class, $body);
            $content = '';
            while ('' !== $chunk = $body(1024)) {
                $content .= $chunk;
            }
            $this->assertStringContainsString('name="file"; filename="'.basename($tmpFile).'"', $content);
            $this->assertStringContainsString('file content', $content);

            return new MockResponse('[]');
        };
        $httpClient = new MockHttpClient($response);

        $handle = fopen($tmpFile, 'rb');
        $this->assertIsResource($handle);

        $jiraClient = new JiraClient($this->configuration, $httpClient);
        $jiraClient->postMultipart('issue/QA-123/attachments', ['file' => $handle]);

        unlink($tmpFile);
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

    public function testGetApiVersion(): void
    {
        $jiraClient = new JiraClient($this->configuration, $this->httpClient);

        $this->assertEquals('3', $jiraClient->getApiVersion());
    }

    public function testConstructorUsesDefaultHttpClientWhenNoneGiven(): void
    {
        $jiraClient = new JiraClient($this->configuration);

        $this->assertEquals('3', $jiraClient->getApiVersion());
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testRequestWithoutCredentialsDoesNotSetAuthBasic(): void
    {
        $configuration = ConfigurationFactory::create([
            'host' => 'https://workspace.atlassian.net',
            'username' => null,
            'password' => null,
        ]);

        $response = function ($method, $url, $options): MockResponse {
            $this->assertArrayNotHasKey('auth_basic', $options);

            return new MockResponse();
        };
        $httpClient = new MockHttpClient($response);

        $jiraClient = new JiraClient($configuration, $httpClient);
        $jiraClient->get('issue/QA-123');
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testRequestWithTokenUsesAuthBearer(): void
    {
        $configuration = ConfigurationFactory::create([
            'host' => 'https://workspace.atlassian.net',
            'token' => 'my-bearer-token',
        ]);

        $response = function ($method, $url, $options): MockResponse {
            $this->assertContains('Authorization: Bearer my-bearer-token', $options['headers']);

            return new MockResponse();
        };
        $httpClient = new MockHttpClient($response);

        $jiraClient = new JiraClient($configuration, $httpClient);
        $jiraClient->get('issue/QA-123');
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testRequestWithTokenTakesPrecedenceOverAuthBasic(): void
    {
        $configuration = ConfigurationFactory::create([
            'host' => 'https://workspace.atlassian.net',
            'username' => 'account@compagny.fr',
            'password' => 'mytoken',
            'token' => 'my-bearer-token',
        ]);

        $response = function ($method, $url, $options): MockResponse {
            $this->assertContains('Authorization: Bearer my-bearer-token', $options['headers']);
            $this->assertNotContains('Authorization: Basic '.base64_encode('account@compagny.fr:mytoken'), $options['headers']);

            return new MockResponse();
        };
        $httpClient = new MockHttpClient($response);

        $jiraClient = new JiraClient($configuration, $httpClient);
        $jiraClient->get('issue/QA-123');
    }

    public function testGetThrowsJiraApiExceptionWithErrorMessagesOn404(): void
    {
        $body = json_encode(['errorMessages' => ['Issue does not exist or you do not have permission to see it.'], 'errors' => []]);
        $this->assertIsString($body);

        $response = new MockResponse($body, ['http_code' => 404]);
        $httpClient = new MockHttpClient($response);

        $jiraClient = new JiraClient($this->configuration, $httpClient);

        try {
            $jiraClient->get('issue/QA-123');
            $this->fail('Expected JiraApiException was not thrown.');
        } catch (JiraApiException $exception) {
            $this->assertSame(404, $exception->getStatusCode());
            $this->assertSame(['Issue does not exist or you do not have permission to see it.'], $exception->getErrorMessages());
            $this->assertSame([], $exception->getErrors());
        }
    }

    public function testPostThrowsJiraApiExceptionWithFieldErrorsOn400(): void
    {
        $body = json_encode(['errorMessages' => [], 'errors' => ['summary' => 'summary is required']]);
        $this->assertIsString($body);

        $response = new MockResponse($body, ['http_code' => 400]);
        $httpClient = new MockHttpClient($response);

        $jiraClient = new JiraClient($this->configuration, $httpClient);

        try {
            $jiraClient->post('issue', ['fields' => []]);
            $this->fail('Expected JiraApiException was not thrown.');
        } catch (JiraApiException $exception) {
            $this->assertSame(400, $exception->getStatusCode());
            $this->assertSame([], $exception->getErrorMessages());
            $this->assertSame(['summary' => 'summary is required'], $exception->getErrors());
            $this->assertStringContainsString('summary: summary is required', $exception->getMessage());
        }
    }

    /**
     * @throws JiraApiException
     */
    public function testGetLetsTransportExceptionsPropagateUnwrapped(): void
    {
        $response = new MockResponse('', ['error' => 'Connection refused']);
        $httpClient = new MockHttpClient($response);

        $jiraClient = new JiraClient($this->configuration, $httpClient);

        $this->expectException(TransportExceptionInterface::class);
        $jiraClient->get('issue/QA-123');
    }

    /**
     * @throws JiraApiException
     */
    public function testGetRetriesOn429AndEventuallySucceeds(): void
    {
        $json = ['key' => 'QA-123'];
        $body = json_encode($json);
        $this->assertIsString($body);

        $responses = [
            new MockResponse('', ['http_code' => 429, 'response_headers' => ['retry-after' => '0']]),
            new MockResponse('', ['http_code' => 429, 'response_headers' => ['retry-after' => '0']]),
            new MockResponse($body, ['http_code' => 200]),
        ];
        $httpClient = new MockHttpClient($responses);

        $jiraClient = new JiraClient($this->configuration, $httpClient);
        $actual = $jiraClient->get('issue/QA-123');

        $this->assertSame(200, $actual->getStatusCode());
        $this->assertSame($json, $actual->toArray());
    }

    public function testGetThrowsJiraApiExceptionAfterExhaustingRetriesOn429(): void
    {
        $body = json_encode(['errorMessages' => ['Rate limit exceeded'], 'errors' => []]);
        $this->assertIsString($body);

        $responses = array_fill(
            0,
            10,
            new MockResponse($body, ['http_code' => 429, 'response_headers' => ['retry-after' => '0']])
        );
        $httpClient = new MockHttpClient($responses);

        $jiraClient = new JiraClient($this->configuration, $httpClient);

        try {
            $jiraClient->get('issue/QA-123');
            $this->fail('Expected JiraApiException was not thrown.');
        } catch (JiraApiException $exception) {
            $this->assertSame(429, $exception->getStatusCode());
            $this->assertSame(['Rate limit exceeded'], $exception->getErrorMessages());
        }
    }

    public function testGetWithoutRetriesFailsImmediatelyOn429(): void
    {
        $body = json_encode(['errorMessages' => ['Rate limit exceeded'], 'errors' => []]);
        $this->assertIsString($body);

        $response = new MockResponse($body, ['http_code' => 429, 'response_headers' => ['retry-after' => '0']]);
        $httpClient = new MockHttpClient($response);

        $jiraClient = new JiraClient($this->configuration, $httpClient, maxRetries: 0);

        $this->expectException(JiraApiException::class);
        $jiraClient->get('issue/QA-123');
    }
}
