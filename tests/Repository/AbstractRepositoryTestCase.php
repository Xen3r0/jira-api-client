<?php

namespace Xen3r0\JiraApiClient\Tests\Repository;

use PHPUnit\Framework\TestCase;

class AbstractRepositoryTestCase extends TestCase
{
    protected function getFixtureContent(string $path): string
    {
        return file_get_contents(sprintf('%s/Fixtures/%s', __DIR__, $path)) ?: '';
    }
}
