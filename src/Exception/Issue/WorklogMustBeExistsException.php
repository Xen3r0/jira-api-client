<?php

namespace Xen3r0\JiraApiClient\Exception\Issue;

class WorklogMustBeExistsException extends \Exception
{
    public function __construct(int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct(
            'Worklog must be exists. Please, check the worklog ID.',
            $code,
            $previous
        );
    }
}
