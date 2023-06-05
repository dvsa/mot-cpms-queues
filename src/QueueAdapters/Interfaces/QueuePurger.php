<?php

namespace DVSA\CPMS\Queues\QueueAdapters\Interfaces;

/**
 * support for writing a message to a named queue
 */
interface QueuePurger
{
    /**
     * purge a queue
     *
     * @param  string $queueName
     *         the name of the queue to purge
     * @param  Queues $queues
     *         our connection to our queues
     * @return object
     *         the metadata about the successfully written message
     */
    public static function to($queueName, Queues $queues);
}