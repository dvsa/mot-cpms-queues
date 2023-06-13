<?php

namespace DVSA\CPMS\Queues\Exceptions;

use RuntimeException;

/**
 * thrown when we've been given config that isn't a string
 */
class E4xx_ConfigKeyMustContainClassNameOfType extends RuntimeException
{
    public function __construct($key, $classname, $expectedType)
    {
        $msg = "invalid config; key '{$key}' must contain PHP classname of type '{$expectedType}', '{$classname}' does not implement / extend '{$expectedType}'";
        parent::__construct($msg, 400);
    }
}