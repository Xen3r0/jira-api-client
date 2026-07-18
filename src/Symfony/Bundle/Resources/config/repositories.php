<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Xen3r0\JiraApiClient\Http\JiraClientInterface;
use Xen3r0\JiraApiClient\Repository\Issue\AttachmentRepository;
use Xen3r0\JiraApiClient\Repository\Issue\AttachmentRepositoryInterface;
use Xen3r0\JiraApiClient\Repository\Issue\CustomFieldOptionRepository;
use Xen3r0\JiraApiClient\Repository\Issue\CustomFieldOptionRepositoryInterface;
use Xen3r0\JiraApiClient\Repository\Issue\IssueCommentRepository;
use Xen3r0\JiraApiClient\Repository\Issue\IssueCommentRepositoryInterface;
use Xen3r0\JiraApiClient\Repository\Issue\IssueLinkRepository;
use Xen3r0\JiraApiClient\Repository\Issue\IssueLinkRepositoryInterface;
use Xen3r0\JiraApiClient\Repository\Issue\IssueRepository;
use Xen3r0\JiraApiClient\Repository\Issue\IssueRepositoryInterface;
use Xen3r0\JiraApiClient\Repository\Issue\IssueTransitionRepository;
use Xen3r0\JiraApiClient\Repository\Issue\IssueTransitionRepositoryInterface;
use Xen3r0\JiraApiClient\Repository\Issue\LinkTypeRepository;
use Xen3r0\JiraApiClient\Repository\Issue\LinkTypeRepositoryInterface;
use Xen3r0\JiraApiClient\Repository\Issue\WorklogRepository;
use Xen3r0\JiraApiClient\Repository\Issue\WorklogRepositoryInterface;
use Xen3r0\JiraApiClient\Repository\Project\ComponentRepository;
use Xen3r0\JiraApiClient\Repository\Project\ComponentRepositoryInterface;
use Xen3r0\JiraApiClient\Repository\Project\ProjectRepository;
use Xen3r0\JiraApiClient\Repository\Project\ProjectRepositoryInterface;
use Xen3r0\JiraApiClient\Repository\Project\VersionRepository;
use Xen3r0\JiraApiClient\Repository\Project\VersionRepositoryInterface;
use Xen3r0\JiraApiClient\Repository\User\UserRepository;
use Xen3r0\JiraApiClient\Repository\User\UserRepositoryInterface;

return static function (ContainerConfigurator $container) {
    $container->services()
        ->set(AttachmentRepositoryInterface::class, AttachmentRepository::class)
            ->args([
                service(JiraClientInterface::class),
                service('serializer'),
            ])
            ->public()

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

        ->set(IssueTransitionRepositoryInterface::class, IssueTransitionRepository::class)
            ->args([
                service(JiraClientInterface::class),
                service('serializer'),
            ])
            ->public()

        ->set(IssueLinkRepositoryInterface::class, IssueLinkRepository::class)
            ->args([
                service(JiraClientInterface::class),
                service('serializer'),
            ])
            ->public()

        ->set(LinkTypeRepositoryInterface::class, LinkTypeRepository::class)
            ->args([
                service(JiraClientInterface::class),
                service('serializer'),
            ])
            ->public()

        ->set(ComponentRepositoryInterface::class, ComponentRepository::class)
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
            ->public()

        ->set(UserRepositoryInterface::class, UserRepository::class)
            ->args([
                service(JiraClientInterface::class),
                service('serializer'),
            ])
            ->public()

        ->set(WorklogRepositoryInterface::class, WorklogRepository::class)
            ->args([
                service(JiraClientInterface::class),
                service('serializer'),
            ])
            ->public();
};
