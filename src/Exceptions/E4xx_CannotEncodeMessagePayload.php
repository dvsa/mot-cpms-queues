<?php

namespace DVSA\CPMS\Queues\Exceptions;

use RuntimeException;

/**
 * thrown when there has been a problem converting a multipart message
 * into a payload
 */
class E4xx_CannotEncodeMessagePayload extends RuntimeException
{
    /**
     * @param string $multipartMessage
     *        the whole message that we could not encode
     * @param string $reason
     *        an explanation of why
     */
    public function __construct($multipartMessage, $reason)
    {
        parent::__construct("cannot encode multipart message: {$reason}; message is: {$multipartMessage}", 400);
    }
}