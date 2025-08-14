<?php

namespace Xen3r0\JiraApiClient\Repository;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Xen3r0\JiraApiClient\Http\JiraClientInterface;
use Xen3r0\JiraApiClient\Serializer\SerializerFactory;

abstract class AbstractRepository
{
    private SerializerInterface $serializer;

    public function __construct(
        protected readonly JiraClientInterface $client,
        ?SerializerInterface $serializer = null,
    ) {
        $this->serializer = $serializer ?? SerializerFactory::create();
    }

    /**
     * @param array<string, mixed> $context
     */
    protected function serialize(object $object, array $context = []): string
    {
        return $this->serializer->serialize($object, 'json', $context);
    }

    protected function deserialize(ResponseInterface $response, string $class): ?object
    {
        $content = $response->getContent();

        return $this->serializer->deserialize($content, $class, 'json');
    }
}
