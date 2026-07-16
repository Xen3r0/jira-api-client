<?php

namespace Xen3r0\JiraApiClient\Tests\Model\User;

use PHPUnit\Framework\TestCase;
use Xen3r0\JiraApiClient\Enum\User\AccountType;
use Xen3r0\JiraApiClient\Model\Avatar\Urls;
use Xen3r0\JiraApiClient\Model\User\User;

class UserTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $avatarUrls = (new Urls())->setX48('https://example.atlassian.net/avatar/48.png');

        $user = (new User())
            ->setAccountId('5b10a2844c20165700ede21g')
            ->setAccountType(AccountType::Atlassian)
            ->setActive(true)
            ->setAvatarUrls($avatarUrls)
            ->setDisplayName('John Doe')
            ->setEmailAddress('john.doe@example.com')
            ->setKey('johndoe')
            ->setName('johndoe')
            ->setSelf('https://example.atlassian.net/rest/api/3/user?accountId=5b10a2844c20165700ede21g')
            ->setTimeZone('Europe/Paris');

        $this->assertEquals('5b10a2844c20165700ede21g', $user->getAccountId());
        $this->assertSame(AccountType::Atlassian, $user->getAccountType());
        $this->assertTrue($user->isActive());
        $this->assertSame($avatarUrls, $user->getAvatarUrls());
        $this->assertEquals('John Doe', $user->getDisplayName());
        $this->assertEquals('john.doe@example.com', $user->getEmailAddress());
        $this->assertEquals('johndoe', $user->getKey());
        $this->assertEquals('johndoe', $user->getName());
        $this->assertEquals('https://example.atlassian.net/rest/api/3/user?accountId=5b10a2844c20165700ede21g', $user->getSelf());
        $this->assertEquals('Europe/Paris', $user->getTimeZone());
    }
}
