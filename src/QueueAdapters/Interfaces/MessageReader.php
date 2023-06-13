<?php

namespace DVSA\CPMS\Queues\QueueAdapters\Interfaces;

interface MessageReader
{
    /**
     * retrieve 1 or more messages from the named queue
     *
     * @param  string  $queueName
     *         the name of the queue that we want to read from
     * @param  Queues  $queues
     *         our connection to our queues
     * @return array
     *         a list of the retrieved messages
     */
    public static function from($queueName, Queues $queues);
}