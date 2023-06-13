<?php

namespace DVSA\CPMS\Queues\QueueAdapters\Values;

class UnexpectedPayload
{
    /**
     * the message payload
     * the data that was written to the queue
     *
     * @var string
     */
    private $messageContents;

    /**
     * a list of the individual steps we took to decode this message
     *
     * @var array
     */
    private $middlewareSteps;

    /**
     * why couldn't we deal with this payload?
     *
     * this will be the error message from the exception thrown by the
     * unhappy middleware
     *
     * @var string
     */
    private $errorMessage;

    /**
     * @param string $messageContents
     *        the message payload *before* any decoding happened
     * @param array $middlewareSteps
     *        detailed description of what we did to decode the message
     * @param string $errorMessage
     *        details about why we could not deal with this payload
     */
    public function __construct($messageContents, $middlewareSteps, $errorMessage)
    {
        $this->messageContents = $messageContents;
        $this->middlewareSteps = $middlewareSteps;
        $this->errorMessage    = $errorMessage;
    }

    /**
     * get the original, undecoded message
     *
     * @return string
     */
    public function getMessageContents()
    {
        return $this->messageContents;
    }

    /**
     * get the list of steps taken to decode this message
     *
     * @return array
     */
    public function getMiddlewareSteps()
    {
        return $this->middlewareSteps;
    }

    /**
     * get the details about why we could not deal with this payload
     *
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
}