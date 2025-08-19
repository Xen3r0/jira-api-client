<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Xen3r0\JiraApiClient\Http\JiraClientInterface;
use Xen3r0\JiraApiClient\Repository\Issue\CustomFieldOptionRepository;
use Xen3r0\JiraApiClient\Repository\Issue\CustomFieldOptionRepositoryInterface;
use Xen3r0\JiraApiClient\Repository\Issue\IssueCommentRepository;
use Xen3r0\JiraApiClient\Repository\Issue\IssueCommentRepositoryInterface;
use Xen3r0\JiraApiClient\Repository\Issue\IssueRepository;
use Xen3r0\JiraApiClient\Repository\Issue\IssueRepositoryInterface;
use Xen3r0\JiraApiClient\Repository\Project\ProjectRepository;
use Xen3r0\JiraApiClient\Repository\Project\ProjectRepositoryInterface;
use Xen3r0\JiraApiClient\Repository\Project\VersionRepository;
use Xen3r0\JiraApiClient\Repository\Project\VersionRepositoryInterface;

return static function (ContainerConfigurator $container) {
    $container->services()
        ->set(CustomFieldOptionRepositoryInterface::class, CustomFieldOptionRepository::class)
            ->args([
                service(JiraClientInterface::class),
                service('serializer'),
            ])
            ->public()

        ->set(IssueCommentRepositoryInterface::class, IssueCommentRepository::class)
            ->args([
                service(JiraClientInterface::class),
                service('serializer'),
            ])
            ->public()

        ->set(IssueRepositoryInterface::class, IssueRepository::class)
            ->args([
                service(JiraClientInterface::class),
                service('serializer'),
            ])
            ->public()

        ->set(ProjectRepositoryInterface::class, ProjectRepository::class)
            ->args([
                service(JiraClientInterface::class),
                service('serializer'),
            ])
            ->public()

        ->set(VersionRepositoryInterface::class, VersionRepository::class)
            ->args([
                service(JiraClientInterface::class),
                service('serializer'),
            ])
            ->public();
};
