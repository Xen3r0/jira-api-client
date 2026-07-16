<?php

namespace Xen3r0\JiraApiClient\Tests\Model\Issue;

use PHPUnit\Framework\TestCase;
use Xen3r0\JiraApiClient\Model\Issue\CustomFieldContextOptionsList;
use Xen3r0\JiraApiClient\Model\Issue\CustomFieldOption;

class CustomFieldContextOptionsListTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $option = (new CustomFieldOption())->setValue('foo');

        $list = (new CustomFieldContextOptionsList())->setOptions([$option]);

        $this->assertSame([$option], $list->getOptions());
    }

    public function testAddOption(): void
    {
        $first = (new CustomFieldOption())->setValue('foo');
        $second = (new CustomFieldOption())->setValue('bar');

        $list = (new CustomFieldContextOptionsList())
            ->setOptions([$first])
            ->addOption($second);

        $this->assertSame([$first, $second], $list->getOptions());
    }
}
