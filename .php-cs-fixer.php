<?php

use PhpCsFixer\Runner\Parallel\ParallelConfigFactory;

$finder = PhpCsFixer\Finder::create()
    ->exclude([
        'vendor',
    ])
    ->filter(function (SplFileInfo $fileInfo) {
        return 'requirements.php' != $fileInfo->getFilename();
    })
    ->in(__DIR__)
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
    ])
    ->setUsingCache(false)
    ->setFinder($finder)
    ->setParallelConfig(ParallelConfigFactory::detect())
;
