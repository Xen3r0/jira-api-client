<?php

namespace Xen3r0\JiraApiClient\Enum\Project;

/**
 * @codeCoverageIgnore
 */
enum AssigneeType: string
{
    case ProjectLead = 'PROJECT_LEAD';
    case Unassigned = 'UNASSIGNED';
}
