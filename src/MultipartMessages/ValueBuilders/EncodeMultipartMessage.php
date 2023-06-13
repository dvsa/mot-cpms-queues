<?php

namespace DVSA\CPMS\Queues\MultipartMessages\ValueBuilders;

use DVSA\CPMS\Queues\MultipartMessages\Maps\MultipartMessageMapper;

class EncodeMultipartMessage
{
    /**
     * use a factory to convert an entity into a multi-part message
     *
     * @param  MultipartMessageMapper $mapper
     *         the helper that will provide the correct factory for
     *         $entity
     * @param  object $entity
     *         the entity to be encoded into a multipart message
     * @return string
     *         the multipart message to write to the queue
     */
    public function __invoke(MultipartMessageMapper $mapper, $entity)
    {
        return self::using($mapper, $entity);
    }

    /**
     * use a factory to convert an entity into a multi-part message
     *
     * @param  MultipartMessageMapper $mapper
     *         the helper that will provide the correct factory for
     *         $entity
     * @param  object $entity
     *         the entity to be encoded into a multipart message
     * @return string
     *         the multipart message to write to the queue
     */
    public static function using(MultipartMessageMapper $mapper, $entity)
    {
        // we need a factory to create the message from this entity
        //
        // if the entity is not supported, the factory will throw a suitable
        // exception
        $factory = $mapper->mapEntityToFactory($entity);

        // at this point, it is up to the factory to convert the entity
        // into a multipart message
        return $factory($entity);
    }
}