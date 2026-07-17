<?php

namespace Xen3r0\JiraApiClient\Repository\Issue;

use Xen3r0\JiraApiClient\Model\Issue\Link;
use Xen3r0\JiraApiClient\Repository\AbstractRepository;

readonly class IssueLinkRepository extends AbstractRepository implements IssueLinkRepositoryInterface
{
    public function add(Link $link): void
    {
        $payload = $this->serialize($link, ['groups' => Link::WRITE_GROUP]);

        $this->client->post('issueLink', $payload);
    }

    public function findById(string $linkId): ?Link
    {
        $response = $this->client->get(sprintf('issueLink/%s', $linkId));

        $result = $this->deserialize($response, Link::class);
        if (!$result instanceof Link) {
            return null;
        }

        return $result;
    }

    public function remove(string $linkId): void
    {
        $this->client->delete(sprintf('issueLink/%s', $linkId));
    }
}
