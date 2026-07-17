<?php

namespace Xen3r0\JiraApiClient\Exception\Http;

use Symfony\Contracts\HttpClient\ResponseInterface;

class JiraApiException extends \Exception
{
    /**
     * @param array<int, string>    $errorMessages
     * @param array<string, string> $errors
     */
    public function __construct(
        private readonly int $statusCode,
        private readonly array $errorMessages = [],
        private readonly array $errors = [],
        ?\Throwable $previous = null,
    ) {
        parent::__construct(self::buildMessage($statusCode, $errorMessages, $errors), $statusCode, $previous);
    }

    public static function fromResponse(ResponseInterface $response, ?\Throwable $previous = null): self
    {
        $statusCode = $response->getStatusCode();
        $content = $response->getContent(false);
        $decoded = json_decode($content, true);

        $errorMessages = is_array($decoded) && is_array($decoded['errorMessages'] ?? null) ? $decoded['errorMessages'] : [];
        $errors = is_array($decoded) && is_array($decoded['errors'] ?? null) ? $decoded['errors'] : [];

        return new self($statusCode, $errorMessages, $errors, $previous);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return array<int, string>
     */
    public function getErrorMessages(): array
    {
        return $this->errorMessages;
    }

    /**
     * @return array<string, string>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param array<int, string>    $errorMessages
     * @param array<string, string> $errors
     */
    private static function buildMessage(int $statusCode, array $errorMessages, array $errors): string
    {
        $parts = [...$errorMessages];
        foreach ($errors as $field => $message) {
            $parts[] = sprintf('%s: %s', $field, $message);
        }

        if ([] === $parts) {
            return sprintf('Jira API request failed with status code %d.', $statusCode);
        }

        return sprintf('Jira API request failed with status code %d: %s', $statusCode, implode(' ', $parts));
    }
}
