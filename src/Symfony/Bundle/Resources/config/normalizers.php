<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Xen3r0\JiraApiClient\Serializer\Normalizer\Issue\CommentNormalizer;
use Xen3r0\JiraApiClient\Serializer\Normalizer\Issue\FieldsNormalizer;
use Xen3r0\JiraApiClient\Serializer\Normalizer\Issue\WorklogNormalizer;

return static function (ContainerConfigurator $container) {
    $container->services()
        ->set(CommentNormalizer::class)
            ->args([service('serializer.normalizer.object')])
            ->tag('serializer.normalizer')

        ->set(FieldsNormalizer::class)
            ->args([service('serializer.normalizer.object')])
            ->tag('serializer.normalizer')

        ->set(WorklogNormalizer::class)
            ->args([service('serializer.normalizer.object')])
            ->tag('serializer.normalizer');
};
