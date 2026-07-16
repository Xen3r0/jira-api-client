<?php

namespace Xen3r0\JiraApiClient\Tests\Model\Issue;

use PHPUnit\Framework\TestCase;
use Xen3r0\JiraApiClient\Model\Issue\CustomFieldOption;
use Xen3r0\JiraApiClient\Model\Issue\CustomFieldOptionSearchResult;

class CustomFieldOptionSearchResultTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $option = (new CustomFieldOption())->setValue('foo');

        $result = (new CustomFieldOptionSearchResult())
            ->setIsLast(true)
            ->setMaxResults(100)
            ->setStartAt(0)
            ->setTotal(1)
            ->setValues([$option]);

        $this->assertTrue($result->getIsLast());
        $this->assertEquals(100, $result->getMaxResults());
        $this->assertEquals(0, $result->getStartAt());
        $this->assertEquals(1, $result->getTotal());
        $this->assertSame([$option], $result->getValues());
    }
}
