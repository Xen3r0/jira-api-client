<?php

namespace Xen3r0\JiraApiClient\Exception\Project;

class VersionMustBeExistsException extends \Exception
{
    public function __construct(int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct(
            'Version must be exists. Please, check the version ID or key.',
            $code,
            $previous
        );
    }
}
