<?php

namespace DVSA\CPMS\Queues\Exceptions;

use RuntimeException;

/**
 * thrown when we've been asked to access a queue, but the config for that
 * queue is not present
 */
class E4xx_NoSuchQueueConfigured extends RuntimeException
{
    /**
     * @param string $queueName
     *        the queue that we have no config for
     */
    public function __construct($queueName)
    {
        parent::__construct("config does not contain details for queue: {$queueName}", 400);
    }
}