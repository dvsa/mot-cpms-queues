<?php

namespace DVSA\CPMS\Queues\MultipartMessages\Maps;

use DVSA\CPMS\Queues\Exceptions\E4xx_UnsupportedEntityType;
use DVSA\CPMS\Queues\Exceptions\E4xx_UnsupportedMessageType;

abstract class MultipartMessageMapper
{
    /**
     * a list of messageTypes, and the factories to use to build the
     * target entities
     *
     * @var array
     */
    protected $messageTypes = [];

    /**
     * a list of entities, and the factories to use to convert them
     * into multipart messages
     *
     * @var array
     */
    protected $entities = [];

    /**
     * given a message type, return the factory required to create the
     * message's entity object
     *
     * @param  string $messageType
     *         the name of the message type
     * @return PayloadDecoderFactory
     *         the factory to use to convert the message payload into
     *         an object
     */
    public function mapMessageTypeToFactory($messageType)
    {
        // do we know about this message type?
        if (!isset($this->messageTypes[$messageType])) {
            throw new E4xx_UnsupportedMessageType($messageType);
        }

        // we're good
        return new $this->messageTypes[$messageType];
    }

    /**
     * given an object, return the factory required to turn the object
     * into a multipart message
     *
     * @param  object $data
     *         the entity to be turned into a multipart message
     * @return PayloadEncoderFactory
     *         the factory to use to convert the entity into a
     *         multipart message
     */
    public function mapEntityToFactory($data)
    {
        $className = get_class($data);
        if (!isset($this->entities[$className])) {
            throw new E4xx_UnsupportedEntityType($className);
        }

        // we're good
        return new $this->entities[$className];
    }
}