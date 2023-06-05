<?php

namespace DVSA\CPMS\Queues\Exceptions;

use RuntimeException;

/**
 * thrown when we have no factory mapped to convert an entity into a
 * multipart message
 */
class E4xx_UnsupportedEntityType extends RuntimeException
{
    /**
     * @param string $className
     *        the entity that we have no mapping for
     */
    public function __construct($className)
    {
        parent::__construct("class '{$className}' is not mapped", 400);
    }
}