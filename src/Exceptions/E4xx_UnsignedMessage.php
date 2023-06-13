<?php

namespace DVSA\CPMS\Queues\Exceptions;

use RuntimeException;

/**
 * thrown when a message had no signature at all
 */
class E4xx_UnsignedMessage extends RuntimeException
{
    /**
     * @param string $message
     *        the message that was unsigned
     */
    public function __construct($message)
    {
        $msg = "received unsigned message: {$message}";
        parent::__construct($msg, 400);
    }
}