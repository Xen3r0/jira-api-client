<?php

namespace Xen3r0\JiraApiClient\Enum\User;

/**
 * @codeCoverageIgnore
 */
enum AccountType: string
{
    case Atlassian = 'atlassian';
    case App = 'app';
    case Customer = 'customer';
    case Unknown = 'unknown';
}
