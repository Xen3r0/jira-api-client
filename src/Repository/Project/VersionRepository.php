<?php

namespace Xen3r0\JiraApiClient\Repository\Project;

use Xen3r0\JiraApiClient\Exception\Project\VersionMustBeExistsException;
use Xen3r0\JiraApiClient\Model\Version\Version;
use Xen3r0\JiraApiClient\Repository\AbstractRepository;

class VersionRepository extends AbstractRepository implements VersionRepositoryInterface
{
    public function findById(string $id): ?Version
    {
        $response = $this->client->get(sprintf('version/%s', $id));

        $result = $this->deserialize($response, Version::class);
        if (!$result instanceof Version) {
            return null;
        }

        return $result;
    }

    public function add(Version $version): ?Version
    {
        $payload = $this->serialize($version, ['groups' => Version::WRITE_GROUP]);

        $response = $this->client->post('version', $payload);
        $result = $this->deserialize($response, Version::class);
        if (!$result instanceof Version) {
            return null;
        }

        return $result;
    }

    /**
     * @throws VersionMustBeExistsException
     */
    public function update(Version $version): ?Version
    {
        if (!$version->getId()) {
            throw new VersionMustBeExistsException();
        }

        $payload = $this->serialize($version, ['groups' => Version::WRITE_GROUP]);

        $response = $this->client->put(sprintf('version/%s', $version->getId()), $payload);
        $result = $this->deserialize($response, Version::class);
        if (!$result instanceof Version) {
            return null;
        }

        return $result;
    }

    public function remove(string $id): void
    {
        $this->client->post(
            sprintf('version/%s/removeAndSwap', $id),
            [
                'customFieldReplacementList' => [],
                'moveAffectedIssuesTo' => null,
                'moveUnfixedIssuesTo' => null,
            ]
        );
    }
}
