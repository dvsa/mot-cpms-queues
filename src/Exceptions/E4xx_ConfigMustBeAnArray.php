<?php

namespace DVSA\CPMS\Queues\Exceptions;

use RuntimeException;

/**
 * thrown when we've been given config that isn't an array (or an object
 * that can pretend to be an array)
 */
class E4xx_ConfigMustBeAnArray extends RuntimeException
{
    public function __construct()
    {
        $msg = "invalid config; must be an array, but we received something else";
        parent::__construct($msg, 400);
    }
}