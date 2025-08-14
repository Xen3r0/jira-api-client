<?php

namespace Xen3r0\JiraApiClient\Enum\Project;

enum AssigneeType: string
{
    case ProjectLead = 'PROJECT_LEAD';
    case Unassigned = 'UNASSIGNED';
}
