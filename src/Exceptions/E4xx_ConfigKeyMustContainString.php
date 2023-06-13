<?php

namespace DVSA\CPMS\Queues\Exceptions;

use RuntimeException;

/**
 * thrown when we've been given config that isn't a string
 */
class E4xx_ConfigKeyMustContainString extends RuntimeException
{
    public function __construct($key)
    {
        $msg = "invalid config; key '{$key}' must be a string, but we received something else";
        parent::__construct($msg, 400);
    }
}