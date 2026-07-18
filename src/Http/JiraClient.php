<?php

namespace Xen3r0\JiraApiClient\Http;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\Retry\GenericRetryStrategy;
use Symfony\Component\HttpClient\RetryableHttpClient;
use Symfony\Component\HttpClient\ScopingHttpClient;
use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Xen3r0\JiraApiClient\Configuration\ConfigurationInterface;
use Xen3r0\JiraApiClient\Enum\Http\Method;
use Xen3r0\JiraApiClient\Enum\Http\StatusCode;
use Xen3r0\JiraApiClient\Exception\Http\JiraApiException;

readonly class JiraClient implements JiraClientInterface
{
    private HttpClientInterface $httpClient;

    public function __construct(
        private readonly ConfigurationInterface $configuration,
        ?HttpClientInterface $httpClient = null,
        int $maxRetries = 3,
    ) {
        if (null === $httpClient) {
            $httpClient = HttpClient::create();
        }

        $options = [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'X-Atlassian-Token' => 'no-check',
                'X-ExperimentalApi' => 'opt-in',
            ],
        ];

        if (null !== $this->configuration->getToken()) {
            $options['auth_bearer'] = $this->configuration->getToken();
        } elseif (null !== $this->configuration->getUsername() && null !== $this->configuration->getPassword()) {
            $options['auth_basic'] = sprintf('%s:%s', $this->configuration->getUsername(), $this->configuration->getPassword());
        }

        $scopedClient = ScopingHttpClient::forBaseUri($httpClient, $this->getBaseUri(), $options);

        $this->httpClient = $maxRetries > 0
            ? new RetryableHttpClient($scopedClient, new GenericRetryStrategy([StatusCode::TooManyRequests->value]), $maxRetries)
            : $scopedClient;
    }

    public function getApiVersion(): string
    {
        return '3';
    }

    /**
     * @param array<string, mixed> $options
     *
     * @throws TransportExceptionInterface
     * @throws JiraApiException
     */
    public function get(string $endpoint, array $options = []): ResponseInterface
    {
        return $this->request(Method::Get, $endpoint, $options);
    }

    /**
     * @param array<string, mixed> $data
     * @param array<string, mixed> $options
     *
     * @throws TransportExceptionInterface
     * @throws JiraApiException
     */
    public function post(string $endpoint, array|string $data, array $options = []): ResponseInterface
    {
        if (is_string($data)) {
            $options['body'] = $data;
        } else {
            $options['json'] = $data;
        }

        return $this->request(Method::Post, $endpoint, $options);
    }

    /**
     * @param array<string, resource|string> $formData
     * @param array<string, mixed>           $options
     *
     * @throws TransportExceptionInterface
     * @throws JiraApiException
     */
    public function postMultipart(string $endpoint, array $formData, array $options = []): ResponseInterface
    {
        $options['body'] = $formData;

        return $this->request(Method::Post, $endpoint, $options);
    }

    /**
     * @param array<string, mixed> $data
     * @param array<string, mixed> $options
     *
     * @throws TransportExceptionInterface
     * @throws JiraApiException
     */
    public function put(string $endpoint, array|string $data, array $options = []): ResponseInterface
    {
        if (is_string($data)) {
            $options['body'] = $data;
        } else {
            $options['json'] = $data;
        }

        return $this->request(Method::Put, $endpoint, $options);
    }

    /**
     * @param array<string, mixed> $options
     *
     * @throws TransportExceptionInterface
     * @throws JiraApiException
     */
    public function delete(string $endpoint, array $options = []): ResponseInterface
    {
        return $this->request(Method::Delete, $endpoint, $options);
    }

    /**
     * @param array<string, mixed> $options
     *
     * @throws TransportExceptionInterface
     * @throws JiraApiException
     */
    private function request(Method $method, string $endpoint, array $options = []): ResponseInterface
    {
        $response = $this->httpClient->request($method->value, $endpoint, $options);

        try {
            $response->getHeaders();
        } catch (HttpExceptionInterface $exception) {
            throw JiraApiException::fromResponse($response, $exception);
        }

        return $response;
    }

    private function getBaseUri(): string
    {
        return sprintf(
            '%s/rest/api/%s/',
            $this->configuration->getHost(),
            $this->getApiVersion()
        );
    }
}
