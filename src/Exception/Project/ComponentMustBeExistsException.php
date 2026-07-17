<?php

namespace Xen3r0\JiraApiClient\Exception\Project;

class ComponentMustBeExistsException extends \Exception
{
    public function __construct(int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct(
            'Component must be exists. Please, check the component ID.',
            $code,
            $previous
        );
    }
}
