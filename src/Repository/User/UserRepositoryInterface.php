<?php

namespace Xen3r0\JiraApiClient\Repository\User;

use Xen3r0\JiraApiClient\Model\User\User;

/**
 * @codeCoverageIgnore
 */
interface UserRepositoryInterface
{
    public function findMyself(): ?User;

    public function findByAccountId(string $accountId): ?User;

    /**
     * @return array<int, User>
     */
    public function search(?string $query = null, int $startAt = 0, int $maxResults = 50): array;
}
