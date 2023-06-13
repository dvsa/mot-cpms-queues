<?php

namespace DVSA\CPMS\Queues\Exceptions;

use RuntimeException;

/**
 * thrown when we have no factory mapped to decode <message-type>
 */
class E4xx_UnsupportedMessageType extends RuntimeException
{
    /**
     * @param string $messageType
     *        the message-type that we have no mapping for
     */
    public function __construct($messageType)
    {
        parent::__construct("message type '{$messageType}' is not mapped", 400);
    }
}