<?php

namespace DVSA\CPMS\Queues\Exceptions;

use RuntimeException;

/**
 * thrown when the <message-type> section of a multipart message is empty
 */
class E4xx_EmptyMessageType extends RuntimeException
{
    /**
     * @param string $multipartMessage
     *        the whole message that we could not decode
     */
    public function __construct($multipartMessage)
    {
        parent::__construct("multipart message contains empty message type; message is {$multipartMessage}", 400);
    }
}