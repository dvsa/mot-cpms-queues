<?php

namespace DVSA\CPMS\Queues\Exceptions;

use RuntimeException;

/**
 * thrown when a message has an invalid signature
 */
class E4xx_UnverifiedMessage extends RuntimeException
{
    /**
     * @param string $message
     *        the message that we could not verify
     * @param string $expectedHmac
     *        the expected signature
     * @param string $actualHmac
     *        the actual signature
     */
    public function __construct($message, $expectedHmac, $actualHmac)
    {
        $msg = "unable to verify message signature; expected '{$expectedHmac}', received '{$actualHmac}', message is: {$message}";
        parent::__construct($msg, 400);
    }
}