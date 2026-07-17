<?php

namespace Xen3r0\JiraApiClient\Repository\User;

use Xen3r0\JiraApiClient\Model\User\User;
use Xen3r0\JiraApiClient\Repository\AbstractRepository;

readonly class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    public function findMyself(): ?User
    {
        $response = $this->client->get('myself');

        $result = $this->deserialize($response, User::class);
        if (!$result instanceof User) {
            return null;
        }

        return $result;
    }

    public function findByAccountId(string $accountId): ?User
    {
        $response = $this->client->get(
            'user',
            [
                'query' => [
                    'accountId' => $accountId,
                ],
            ]
        );

        $result = $this->deserialize($response, User::class);
        if (!$result instanceof User) {
            return null;
        }

        return $result;
    }

    /**
     * @return array<int, User>
     */
    public function search(?string $query = null, int $startAt = 0, int $maxResults = 50): array
    {
        $response = $this->client->get(
            'user/search',
            [
                'query' => [
                    'query' => $query,
                    'startAt' => $startAt,
                    'maxResults' => $maxResults,
                ],
            ]
        );

        /** @var array<int, User> $result */
        $result = $this->deserializeList($response, User::class);

        return $result;
    }
}
