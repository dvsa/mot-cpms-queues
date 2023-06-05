<?php

namespace DVSA\CPMS\Queues\Exceptions;

use Exception;
use RuntimeException;

/**
 * exception thrown when we cannot generate a new message ID
 */
class E5xx_CannotGenerateMessageId extends RuntimeException
{
    /**
     * constructor
     *
     * @param string $message
     *        the reason why we cannot generate a new message ID
     * @param Exception $cause
     *        the underlying error that we are wrapping
     */
    public function __construct($message, Exception $cause = null)
    {
        parent::__construct($message, 500, $cause);
    }

    /**
     * create a new instance from an existing exception
     *
     * @param  Exception $cause
     *         the exception that caused this error
     * @return E5xx_CannotGenerateMessageId
     */
    public static function newFromException(Exception $cause)
    {
        return new static($cause->getMessage(), $cause);
    }
}