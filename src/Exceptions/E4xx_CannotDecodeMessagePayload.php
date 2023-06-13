<?php

namespace DVSA\CPMS\Queues\Exceptions;

use RuntimeException;

/**
 * thrown when there has been a problem decoding the payload section of
 * a multipart message
 */
class E4xx_CannotDecodeMessagePayload extends RuntimeException
{
    /**
     * @param string $multipartMessage
     *        the whole message that we could not decode
     * @param string $reason
     *        an explanation of why
     */
    public function __construct($multipartMessage, $reason)
    {
        parent::__construct("cannot decode multipart message: {$reason}; message is: {$multipartMessage}", 400);
    }
}