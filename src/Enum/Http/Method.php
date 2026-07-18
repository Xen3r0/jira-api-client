<?php

namespace Xen3r0\JiraApiClient\Enum\Http;

/**
 * @codeCoverageIgnore
 */
enum Method: string
{
    case Get = 'GET';
    case Post = 'POST';
    case Put = 'PUT';
    case Delete = 'DELETE';
}
