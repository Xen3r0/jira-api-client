<?php

namespace Xen3r0\JiraApiClient\Exception\Issue;

class CommentBodyEmptyException extends \Exception
{
    public function __construct(int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct(
            'The comment body cannot be empty.',
            $code,
            $previous
        );
    }
}
