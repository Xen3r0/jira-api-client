<?php

namespace Xen3r0\JiraApiClient\Http;

use Symfony\Contracts\HttpClient\ResponseInterface;

interface JiraClientInterface
{
    public function getApiVersion(): string;

    /**
     * @param array<string, mixed> $options
     */
    public function get(string $endpoint, array $options = []): ResponseInterface;

    /**
     * @param array<string|int, mixed>|string $data
     * @param array<string, mixed>            $options
     */
    public function post(string $endpoint, array|string $data, array $options = []): ResponseInterface;

    /**
     * @param array<string|int, mixed>|string $data
     * @param array<string, mixed>            $options
     */
    public function put(string $endpoint, array|string $data, array $options = []): ResponseInterface;

    /**
     * @param array<string, mixed> $options
     */
    public function delete(string $endpoint, array $options = []): ResponseInterface;
}
