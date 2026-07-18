<?php

namespace Xen3r0\JiraApiClient\Repository\Issue;

use Xen3r0\JiraApiClient\Model\Issue\Attachment;
use Xen3r0\JiraApiClient\Repository\AbstractRepository;

readonly class AttachmentRepository extends AbstractRepository implements AttachmentRepositoryInterface
{
    /**
     * @return array<int, Attachment>
     *
     * @throws \InvalidArgumentException
     */
    public function add(string $issueIdOrKey, string $filePath): array
    {
        $handle = is_readable($filePath) ? fopen($filePath, 'rb') : false;
        if (false === $handle) {
            throw new \InvalidArgumentException(sprintf('File "%s" does not exist or is not readable.', $filePath));
        }

        $response = $this->client->postMultipart(
            sprintf('issue/%s/attachments', $issueIdOrKey),
            ['file' => $handle]
        );

        /** @var array<int, Attachment> $result */
        $result = $this->deserializeList($response, Attachment::class);

        return $result;
    }

    public function findById(string $id): ?Attachment
    {
        $response = $this->client->get(sprintf('attachment/%s', $id));

        $result = $this->deserialize($response, Attachment::class);
        if (!$result instanceof Attachment) {
            return null;
        }

        return $result;
    }

    public function remove(string $id): void
    {
        $this->client->delete(sprintf('attachment/%s', $id));
    }

    public function getContent(string $id): string
    {
        return $this->client->get(sprintf('attachment/content/%s', $id))->getContent();
    }
}
