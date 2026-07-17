<?php

namespace Xen3r0\JiraApiClient\Model\Issue;

class LinkTypeSearchResult
{
    /**
     * @var array<int, LinkType>
     */
    private array $issueLinkTypes = [];

    /**
     * @return array<int, LinkType>
     */
    public function getIssueLinkTypes(): array
    {
        return $this->issueLinkTypes;
    }

    /**
     * @param array<int, LinkType> $issueLinkTypes
     */
    public function setIssueLinkTypes(array $issueLinkTypes): static
    {
        $this->issueLinkTypes = $issueLinkTypes;

        return $this;
    }
}
