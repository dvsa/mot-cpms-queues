<?php

namespace DVSA\CPMS\Queues\Exceptions;

use RuntimeException;

/**
 * thrown when we've been asked to build middleware, but we've been asked
 * to use a middleware builder class that we consider invalid
 */
class E4xx_InvalidMiddlewareBuilder extends RuntimeException
{
    /**
     * @param string $name
     *        the middleware that we've been asked to build
     */
    public function __construct($name)
    {
        parent::__construct("class '{$name}' is not a valid middleware builder", 400);
    }
}