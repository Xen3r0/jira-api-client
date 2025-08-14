<?php

namespace Xen3r0\JiraApiClient\Enum\Issue;

enum IssueCommentOrder: string
{
    case Created = 'created';
    case CreatedAsc = '+created';
    case CreatedDesc = '-created';
}
