<?php

namespace DVSA\CPMS\Queues\Middleware\PayloadEditors;

use DVSA\CPMS\Queues\Exceptions\E4xx_CannotEncodeMessagePayload;
use DVSA\CPMS\Queues\Middleware\Interfaces\PayloadEncoder;
use DVSA\CPMS\Queues\MultipartMessages\ValueBuilders\EncodeMultipartMessage;
use DVSA\CPMS\Queues\MultipartMessages\Maps\MultipartMessageMapper;

class BuildPayloadFromMultipartMessage implements PayloadEncoder
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
     * encode the contents of a message
     *
     * @param  object $payload
     *         the message to be modified
     * @return string
     *         the modified message
     */
    public function __invoke($payload)
    {
        if (!is_object($payload)) {
            throw new E4xx_CannotEncodeMessagePayload(var_export($payload, true), "payload is not an object");
        }

        // convert our notification into a message to send
        $newPayload = EncodeMultipartMessage::using($this->mapper, $payload);

        // all done
        return $newPayload;
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