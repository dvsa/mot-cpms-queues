<?php

namespace DVSA\CPMS\Queues\Exceptions;

use RuntimeException;

/**
 * thrown when there has been a problem encrypting the payload section of
 * a message
 */
class E4xx_CannotEncryptMessagePayload extends RuntimeException
{
    /**
     * @param string $reason
     *        an explanation of why
     */
    public function __construct($reason)
    {
        parent::__construct("cannot encrypt message: {$reason}", 400);
    }
}