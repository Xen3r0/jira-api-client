<?php

namespace Xen3r0\JiraApiClient\Tests\Repository\User;

use Symfony\Contracts\HttpClient\ResponseInterface;
use Xen3r0\JiraApiClient\Http\JiraClientInterface;
use Xen3r0\JiraApiClient\Model\User\User;
use Xen3r0\JiraApiClient\Repository\User\UserRepository;
use Xen3r0\JiraApiClient\Tests\Repository\AbstractRepositoryTestCase;

class UserRepositoryTest extends AbstractRepositoryTestCase
{
    public function testFindMyself(): void
    {
        $content = $this->getFixtureContent('User/get_myself.json');
        $jiraClient = $this->createMock(JiraClientInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $jiraClient
            ->expects($this->once())
            ->method('get')
            ->with('myself')
            ->willReturn($response);

        $response
            ->expects($this->once())
            ->method('getContent')
            ->willReturn($content);

        $repository = new UserRepository($jiraClient);
        $actual = $repository->findMyself();

        $this->assertInstanceOf(User::class, $actual);
        $this->assertEquals('5b10a2844c20165700ede21g', $actual->getAccountId());
        $this->assertEquals('John Doe', $actual->getDisplayName());
    }

    public function testFindByAccountId(): void
    {
        $content = $this->getFixtureContent('User/get_user.json');
        $jiraClient = $this->createMock(JiraClientInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $jiraClient
            ->expects($this->once())
            ->method('get')
            ->with('user', ['query' => ['accountId' => '5b10a2844c20165700ede21g']])
            ->willReturn($response);

        $response
            ->expects($this->once())
            ->method('getContent')
            ->willReturn($content);

        $repository = new UserRepository($jiraClient);
        $actual = $repository->findByAccountId('5b10a2844c20165700ede21g');

        $this->assertInstanceOf(User::class, $actual);
        $this->assertEquals('5b10a2844c20165700ede21g', $actual->getAccountId());
    }

    public function testSearch(): void
    {
        $content = $this->getFixtureContent('User/search_users.json');
        $jiraClient = $this->createMock(JiraClientInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $jiraClient
            ->expects($this->once())
            ->method('get')
            ->with('user/search', ['query' => ['query' => 'Doe', 'startAt' => 0, 'maxResults' => 50]])
            ->willReturn($response);

        $response
            ->expects($this->once())
            ->method('getContent')
            ->willReturn($content);

        $repository = new UserRepository($jiraClient);
        $actual = $repository->search('Doe');

        $this->assertCount(2, $actual);
        $this->assertInstanceOf(User::class, $actual[0]);
        $this->assertEquals('John Doe', $actual[0]->getDisplayName());
        $this->assertEquals('Jane Doe', $actual[1]->getDisplayName());
    }
}
