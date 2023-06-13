<?php

namespace DVSA\CPMS\Queues\Middleware\PayloadEditors;

use DVSA\CPMS\Queues\Exceptions\E4xx_CannotDecodeMessagePayload;
use DVSA\CPMS\Queues\Middleware\Interfaces\PayloadDecoder;
use DVSA\CPMS\Queues\MultipartMessages\ValueBuilders\DecodeMultipartMessage;
use DVSA\CPMS\Queues\MultipartMessages\Maps\MultipartMessageMapper;
use DVSA\CPMS\Queues\QueueAdapters\Values\QueueMessage;

class BuildMultipartMessageFromPayload implements PayloadDecoder
{
    /**
     * helper class - tells us which ValueBuilder to use for the incoming
     * data
     *
     * @var MultipartMessageMapper
     */
    private $mapper;

    /**
     * our constructor
     *
     * @param MultipartMessageMapper $mapper
     *        how do we map incoming content onto messages?
     */
    public function __construct(MultipartMessageMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * modify a message's contents after the message has been read from a queue
     *
     * @param  mixed $payload
     *         the contents to be modified
     * @return mixed
     *         the modified contents
     */
    public function __invoke($payload)
    {
        // we only operate on strings
        if (!is_string($payload)) {
            throw new E4xx_CannotDecodeMessagePayload(var_export($payload, true), "payload is not a string");
        }

        // convert the message's payload into a notification entity
        $entity = DecodeMultipartMessage::using($this->mapper, $payload);

        // all done
        return $entity;
    }

    /**
     * what is the name of config key, in the overall 'Middleware' section
     * of the config?
     *
     * @return string
     */
    public function getMiddlewareName()
    {
        return 'MultipartMessage';
    }
}