<?php

namespace Xen3r0\JiraApiClient\Model\Issue;

use Symfony\Component\Serializer\Attribute\Groups;

class CustomFieldContextOptionsList
{
    /**
     * @var array<int, CustomFieldOption>
     */
    #[Groups(groups: [CustomFieldOption::WRITE_GROUP])]
    private array $options = [];

    /**
     * @return array<int, CustomFieldOption>
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param array<int, CustomFieldOption> $options
     */
    public function setOptions(array $options): static
    {
        $this->options = $options;

        return $this;
    }
}
