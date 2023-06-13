<?php

namespace DVSA\CPMS\Queues\Exceptions;

use RuntimeException;

/**
 * thrown when there has been a problem decrypting the payload section of
 * a message
 */
class E4xx_CannotDecryptMessagePayload extends RuntimeException
{
    /**
     * @param string $reason
     *        an explanation of why
     */
    public function __construct($reason)
    {
        parent::__construct("cannot decrypt message: {$reason}", 400);
    }
}