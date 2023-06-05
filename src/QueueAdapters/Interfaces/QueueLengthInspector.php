<?php

namespace DVSA\CPMS\Queues\QueueAdapters\Interfaces;

interface QueueLengthInspector
{
    /**
     * get the number of messages that are in the queue and waiting to be
     * processed
     *
     * NOTES:
     *
     * * this number may be an approximate number
     *
     * @param  string $queueName
     *         the name of the queue to inspect
     * @param  Queues $queues
     *         our connection to our queues
     * @return int
     *         the number of messages waiting in the queue
     */
    public static function from($queueName, Queues $queues);
}