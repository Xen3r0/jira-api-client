<?php

namespace Xen3r0\JiraApiClient\Repository\Issue;

use Xen3r0\JiraApiClient\Model\Issue\LinkType;
use Xen3r0\JiraApiClient\Model\Issue\LinkTypeSearchResult;
use Xen3r0\JiraApiClient\Repository\AbstractRepository;

readonly class LinkTypeRepository extends AbstractRepository implements LinkTypeRepositoryInterface
{
    public function findAll(): array
    {
        $response = $this->client->get('issueLinkType');

        $result = $this->deserialize($response, LinkTypeSearchResult::class);
        if (!$result instanceof LinkTypeSearchResult) {
            return [];
        }

        return $result->getIssueLinkTypes();
    }

    public function findById(string $id): ?LinkType
    {
        $response = $this->client->get(sprintf('issueLinkType/%s', $id));

        $result = $this->deserialize($response, LinkType::class);
        if (!$result instanceof LinkType) {
            return null;
        }

        return $result;
    }
}
