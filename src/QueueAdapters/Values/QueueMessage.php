<?php

namespace DVSA\CPMS\Queues\QueueAdapters\Values;

class QueueMessage
{
    /**
     * the message payload
     * the data that was written to the queue
     *
     * @var string
     */
    private $messageContents;

    /**
     * the queueing system's metadata for this message
     *
     * you should treat this as opaque
     *
     * @var mixed
     */
    private $messageMetadata;

    /**
     * a list of the individual steps we took to decode this message
     *
     * @var array
     */
    private $middlewareSteps;

    /**
     * @param string $messageContents
     *        the message payload
     * @param mixed $messageMetadata
     *        the queueing system's metadata for this message
     * @param array $middlewareSteps
     *        detailed description of what we did to decode the message
     */
    public function __construct($messageContents, $messageMetadata, $middlewareSteps = [])
    {
        $this->messageContents = $messageContents;
        $this->messageMetadata = $messageMetadata;
        $this->middlewareSteps = $middlewareSteps;
    }

    /**
     * get the raw contents of this message
     *
     * @return string
     * @deprecated use getPayload() instead
     */
    public function getRawContents()
    {
        return $this->getPayload();
    }

    /**
     * get the message's data payload
     *
     * @return string
     */
    public function getPayload()
    {
        return $this->messageContents;
    }

    /**
     * get the metadata associated with this message
     *
     * You should treat this as opaque. This metadata is for use by the
     * queue adapters only.
     *
     * @return mixed
     */
    public function getMetadata()
    {
        return $this->messageMetadata;
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
}