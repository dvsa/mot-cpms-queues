<?php

namespace DVSA\CPMS\Queues\QueueAdapters\Interfaces;

/**
 * support for writing a message to a named queue
 */
interface MessageWriter
{
    /**
     * write a message to a queue
     *
     * @param  string $queueName
     *         the name of the queue to write to
     * @param  Queues $queues
     *         our connection to our queues
     * @param  string $message
     *         the message to write
     * @return object
     *         the metadata about the successfully written message
     */
    public static function to($queueName, Queues $queues, $message);
}