<?php

namespace DVSA\CPMS\Queues\Exceptions;

use RuntimeException;

/**
 * thrown when we've been asked to build middleware, but we can't find
 * the class to build it
 */
class E4xx_NoSuchMiddleware extends RuntimeException
{
    /**
     * @param string $name
     *        the middleware that we've been asked to build
     */
    public function __construct($name)
    {
        parent::__construct("cannot find middleware class '{$name}' to build middleware", 400);
    }
}