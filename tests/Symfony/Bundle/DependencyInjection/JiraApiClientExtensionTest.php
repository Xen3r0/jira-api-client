<?php

namespace Xen3r0\JiraApiClient\Tests\Symfony\Bundle\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Xen3r0\JiraApiClient\Configuration\ConfigurationInterface as JiraApiClientConfigurationInterface;
use Xen3r0\JiraApiClient\Http\JiraClientInterface;
use Xen3r0\JiraApiClient\Repository\Issue\CustomFieldOptionRepositoryInterface;
use Xen3r0\JiraApiClient\Repository\Issue\IssueCommentRepositoryInterface;
use Xen3r0\JiraApiClient\Repository\Issue\IssueRepositoryInterface;
use Xen3r0\JiraApiClient\Repository\Project\ProjectRepositoryInterface;
use Xen3r0\JiraApiClient\Repository\Project\VersionRepositoryInterface;
use Xen3r0\JiraApiClient\Serializer\Normalizer\Issue\CommentNormalizer;
use Xen3r0\JiraApiClient\Serializer\Normalizer\Issue\FieldsNormalizer;
use Xen3r0\JiraApiClient\Symfony\Bundle\DependencyInjection\JiraApiClientExtension;

class JiraApiClientExtensionTest extends TestCase
{
    public function testLoadWithCredentials(): void
    {
        $container = new ContainerBuilder();

        (new JiraApiClientExtension())->load(
            [
                [
                    'http' => [
                        'host' => 'https://example.atlassian.net',
                        'username' => 'john.doe@example.com',
                        'password' => 'secret',
                    ],
                ],
            ],
            $container
        );

        $this->assertEquals('https://example.atlassian.net', $container->getParameter('jira_api_client.http.host'));
        $this->assertEquals('john.doe@example.com', $container->getParameter('jira_api_client.http.username'));
        $this->assertEquals('secret', $container->getParameter('jira_api_client.http.password'));

        $this->assertTrue($container->hasDefinition(JiraApiClientConfigurationInterface::class));
        $this->assertTrue($container->hasDefinition(JiraClientInterface::class));
        $this->assertTrue($container->hasDefinition(CommentNormalizer::class));
        $this->assertTrue($container->hasDefinition(FieldsNormalizer::class));
        $this->assertTrue($container->hasDefinition(CustomFieldOptionRepositoryInterface::class));
        $this->assertTrue($container->hasDefinition(IssueCommentRepositoryInterface::class));
        $this->assertTrue($container->hasDefinition(IssueRepositoryInterface::class));
        $this->assertTrue($container->hasDefinition(ProjectRepositoryInterface::class));
        $this->assertTrue($container->hasDefinition(VersionRepositoryInterface::class));

        $methodCalls = $container->getDefinition(JiraApiClientConfigurationInterface::class)->getMethodCalls();
        $this->assertSame(['setUsername', ['john.doe@example.com']], $methodCalls[0]);
        $this->assertSame(['setPassword', ['secret']], $methodCalls[1]);
    }

    public function testLoadWithoutCredentials(): void
    {
        $container = new ContainerBuilder();

        (new JiraApiClientExtension())->load(
            [
                [
                    'http' => [
                        'host' => 'https://example.atlassian.net',
                    ],
                ],
            ],
            $container
        );

        $this->assertNull($container->getParameter('jira_api_client.http.username'));
        $this->assertNull($container->getParameter('jira_api_client.http.password'));
        $this->assertEmpty($container->getDefinition(JiraApiClientConfigurationInterface::class)->getMethodCalls());
    }
}
