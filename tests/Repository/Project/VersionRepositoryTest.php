<?php

namespace Xen3r0\JiraApiClient\Tests\Repository\Project;

use Symfony\Contracts\HttpClient\ResponseInterface;
use Xen3r0\JiraApiClient\Exception\Project\VersionMustBeExistsException;
use Xen3r0\JiraApiClient\Http\JiraClient;
use Xen3r0\JiraApiClient\Model\Version\Version;
use Xen3r0\JiraApiClient\Repository\Project\VersionRepository;
use Xen3r0\JiraApiClient\Tests\Repository\AbstractRepositoryTestCase;

class VersionRepositoryTest extends AbstractRepositoryTestCase
{
    public function testFindById(): void
    {
        $content = $this->getFixtureContent('Project/get_version.json');
        $jiraClient = $this->createMock(JiraClient::class);
        $response = $this->createMock(ResponseInterface::class);

        $jiraClient
            ->expects($this->once())
            ->method('get')
            ->with('version/123')
            ->willReturn($response);

        $response
            ->expects($this->once())
            ->method('getContent')
            ->willReturn($content);

        $repository = new VersionRepository($jiraClient);
        $actual = $repository->findById('123');
        $this->assertNotNull($actual);
        $this->assertNotEmpty($actual->getName());
        $this->assertNotEmpty($actual->getProjectId());
        $this->assertNotEmpty($actual->getReleaseDate());
        $this->assertNotEmpty($actual->getUserReleaseDate());
    }

    public function testAdd(): void
    {
        $version = (new Version())
            ->setName('2.1.0')
            ->setDescription('Release 2.1.0')
            ->setReleaseDate(new \DateTimeImmutable('2025-08-18'));
        $payload = ['name' => '2.1.0', 'description' => 'Release 2.1.0', 'archived' => false, 'released' => false, 'releaseDate' => '2025-08-18T00:00:00+00:00'];
        $result = ['id' => '2000', ...$payload];

        $jiraClient = $this->createMock(JiraClient::class);
        $response = $this->createMock(ResponseInterface::class);

        $jiraClient
            ->expects($this->once())
            ->method('post')
            ->with('version', json_encode($payload))
            ->willReturn($response);

        $response
            ->expects($this->once())
            ->method('getContent')
            ->willReturn(json_encode($result));

        $repository = new VersionRepository($jiraClient);
        $actual = $repository->add($version);
        $this->assertInstanceOf(Version::class, $actual);
        $this->assertEquals('2000', $actual->getId());
        $this->assertEquals('2.1.0', $actual->getName());
        $this->assertFalse($actual->getArchived());
        $this->assertEquals('Release 2.1.0', $actual->getDescription());
        $this->assertEquals(new \DateTimeImmutable('2025-08-18'), $actual->getReleaseDate());
    }

    public function testUpdate(): void
    {
        $version = (new Version())
            ->setId('2000')
            ->setName('2.1.0')
            ->setDescription('Release 2.1.0')
            ->setReleaseDate(new \DateTimeImmutable('2025-08-18'));
        $payload = ['id' => '2000', 'name' => '2.1.0', 'description' => 'Release 2.1.0', 'archived' => false, 'released' => false, 'releaseDate' => '2025-08-18T00:00:00+00:00'];
        $result = [...$payload];

        $jiraClient = $this->createMock(JiraClient::class);
        $response = $this->createMock(ResponseInterface::class);

        $jiraClient
            ->expects($this->once())
            ->method('put')
            ->with('version/2000', json_encode($payload))
            ->willReturn($response);

        $response
            ->expects($this->once())
            ->method('getContent')
            ->willReturn(json_encode($result));

        $repository = new VersionRepository($jiraClient);
        $actual = $repository->update($version);
        $this->assertInstanceOf(Version::class, $actual);
        $this->assertEquals('2000', $actual->getId());
        $this->assertEquals('2.1.0', $actual->getName());
        $this->assertFalse($actual->getArchived());
        $this->assertEquals('Release 2.1.0', $actual->getDescription());
        $this->assertEquals(new \DateTimeImmutable('2025-08-18'), $actual->getReleaseDate());
    }

    public function testUpdateOnNewVersion(): void
    {
        $version = (new Version())
            ->setName('2.1.0')
            ->setDescription('Release 2.1.0')
            ->setReleaseDate(new \DateTimeImmutable('2025-08-18'));

        $jiraClient = $this->createMock(JiraClient::class);

        $this->expectException(VersionMustBeExistsException::class);

        $repository = new VersionRepository($jiraClient);
        $repository->update($version);
    }

    public function testRemove(): void
    {
        $versionId = '2000';

        $jiraClient = $this->createMock(JiraClient::class);
        $response = $this->createMock(ResponseInterface::class);

        $jiraClient
            ->expects($this->once())
            ->method('post')
            ->with(
                'version/2000/removeAndSwap',
                [
                    'customFieldReplacementList' => [],
                    'moveAffectedIssuesTo' => null,
                    'moveUnfixedIssuesTo' => null,
                ]
            )
            ->willReturn($response);

        $repository = new VersionRepository($jiraClient);
        $repository->remove($versionId);
    }
}
