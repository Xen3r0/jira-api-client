<?php

namespace Xen3r0\JiraApiClient\Exception\Issue;

class IssueMustBeExistsException extends \Exception
{
    public function __construct(int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct(
            'Issue must be exists. Please, check the issue ID or key.',
            $code,
            $previous
        );
    }
}
