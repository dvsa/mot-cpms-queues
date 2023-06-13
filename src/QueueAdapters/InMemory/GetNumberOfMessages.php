<?php

namespace DVSA\CPMS\Queues\QueueAdapters\InMemory;

use DVSA\CPMS\Queues\QueueAdapters\Interfaces\Queues;
use DVSA\CPMS\Queues\QueueAdapters\Interfaces\QueueLengthInspector;

class GetNumberOfMessages implements QueueLengthInspector
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
    public function __invoke($queueName, Queues $queues)
    {
        return self::from($queueName, $queues);
    }

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
    public static function from($queueName, Queues $queues)
    {
        // we need this to inspect the queue
        $queuesList = $queues->getClient();
        $queue = $queuesList[$queueName];

        // couldn't be easier :)
        return $queue->getQueueLength();
    }
}