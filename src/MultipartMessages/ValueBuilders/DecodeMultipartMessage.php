<?php

namespace DVSA\CPMS\Queues\MultipartMessages\ValueBuilders;

use DVSA\CPMS\Queues\Exceptions\E4xx_CannotDecodeMessagePayload;
use DVSA\CPMS\Queues\Exceptions\E4xx_EmptyMessageType;
use DVSA\CPMS\Queues\Exceptions\E4xx_InvalidMessageFormat;
use DVSA\CPMS\Queues\MultipartMessages\Maps\MultipartMessageMapper;

class DecodeMultipartMessage
{
    /**
     * use a factory to decode a multi-part message into a useful object
     *
     * @param  MultipartMessageMapper $mapper
     *         the helper that will provide the correct factory for
     *         $message
     * @param  string $message
     *         the message to be decoded
     * @return object
     *         whatever object that $factory builds
     *
     * @throws E4xx_InvalidMessageFormat
     *         if the message isn't a multipart message
     * @throws E4xx_CannotDecodeMessagePayload
     */
    public function __invoke($mapper, $message)
    {
        return self::using($mapper, $message);
    }

    /**
     * use a factory to decode a multi-part message into a useful object
     *
     * @param  MultipartMessageMapper $mapper
     *         the helper that will provide the correct factory for
     *         $message
     * @param  string $message
     *         the message to be decoded
     * @return object
     *         whatever object that $factory builds
     *
     * @throws E4xx_InvalidMessageFormat
     *         if the message isn't a multipart message
     * @throws E4xx_EmptyMessageType
     *         if part 1 of the message is empty
     * @throws E4xx_CannotDecodeMessagePayload
     *         if part 2 of the message does not contain valid JSON
     */
    public static function using(MultipartMessageMapper $mapper, $message)
    {
        // our message is made of two sections:
        //
        // <message-type>
        // <JSON-PAYLOAD>
        //
        // we check that here, to make sure that $factory gets something
        // it should be able to work with
        $parts = explode("\n", $message);
        if (count($parts) < 2) {
            throw new E4xx_InvalidMessageFormat($message);
        }

        // make sure there is a message type, and that it isn't empty
        $messageType = trim(array_shift($parts));
        if (strlen($messageType) === 0) {
            throw new E4xx_EmptyMessageType($message);
        }

        // make sure we have a payload that is usable
        $payload = implode("\n", $parts);
        $data = @json_decode($payload);
        if (null === $data) {
            throw new E4xx_CannotDecodeMessagePayload($message, "invalid JSON");
        }

        // now we need a factory
        // this factory will generate the correct type of entity for
        // the message type that we have received
        $factory = $mapper->mapMessageTypeToFactory($messageType);

        // at this point, it is up to the factory to convert the message
        // into an object or entity to be used
        return $factory($data);
    }
}