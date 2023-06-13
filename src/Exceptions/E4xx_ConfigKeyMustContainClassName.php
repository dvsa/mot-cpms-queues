<?php

namespace DVSA\CPMS\Queues\Exceptions;

use RuntimeException;

/**
 * thrown when we've been given config that isn't a string
 */
class E4xx_ConfigKeyMustContainClassName extends RuntimeException
{
    public function __construct($key, $classname)
    {
        $msg = "invalid config; key '{$key}' must contain a valid PHP classname, cannot find/autoload class '{$classname}'";
        parent::__construct($msg, 400);
    }
}