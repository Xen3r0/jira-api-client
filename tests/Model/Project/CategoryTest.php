<?php

namespace Xen3r0\JiraApiClient\Tests\Model\Project;

use PHPUnit\Framework\TestCase;
use Xen3r0\JiraApiClient\Model\Project\Category;

class CategoryTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $category = (new Category())
            ->setId('10000')
            ->setName('Support')
            ->setDescription('Support projects')
            ->setSelf('https://example.atlassian.net/rest/api/3/projectCategory/10000');

        $this->assertEquals('10000', $category->getId());
        $this->assertEquals('Support', $category->getName());
        $this->assertEquals('Support projects', $category->getDescription());
        $this->assertEquals('https://example.atlassian.net/rest/api/3/projectCategory/10000', $category->getSelf());
    }
}
