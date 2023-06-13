<?php

namespace DVSA\CPMS\Queues\Exceptions;

use InvalidArgumentException;

/**
 * thrown when we don't have a multipart message to work with
 */
class E4xx_InvalidMessageFormat extends InvalidArgumentException
{
    /**
     * @param string $multipartMessage
     *        the message that is invalid
     */
    public function __construct($multipartMessage)
    {
        parent::__construct("not a multipart message; message is: {$multipartMessage}", 400);
    }
}