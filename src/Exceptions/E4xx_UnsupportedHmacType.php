<?php

namespace DVSA\CPMS\Queues\Exceptions;

use RuntimeException;

/**
 * thrown when we've been given a hmac algorithm that this version of PHP
 * does not support
 */
class E4xx_UnsupportedHmacType extends RuntimeException
{
    /**
     * @param string $hmacType
     *        the algorithm that this version of PHP does not support
     */
    public function __construct($hmacType)
    {
        $msg = "hmac algorithm '{$hmacType}' not supported; available types are: " . implode(',', hash_algos());
        parent::__construct($msg, 400);
    }
}