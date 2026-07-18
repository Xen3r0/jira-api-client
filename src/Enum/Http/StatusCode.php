<?php

namespace Xen3r0\JiraApiClient\Enum\Http;

/**
 * @codeCoverageIgnore
 */
enum StatusCode: int
{
    case TooManyRequests = 429;
}
