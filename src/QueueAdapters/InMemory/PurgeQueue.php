<?php

namespace DVSA\CPMS\Queues\QueueAdapters\InMemory;

use DVSA\CPMS\Queues\QueueAdapters\Interfaces\QueuePurger;
use DVSA\CPMS\Queues\QueueAdapters\Interfaces\Queues;

class PurgeQueue implements QueuePurger
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
    public function __invoke($queueName, Queues $queues)
    {
        return self::to($queueName, $queues);
    }

    /**
     * Purge a queue
     *
     * @param  string $queueName
     *         the name of the queue to purge
     * @param  Queues $queues
     *         our connection to our queues
     * @return object
     *         the metadata about the successfully written message
     */
    public static function to($queueName, Queues $queues)
    {
        // we need this to purge the queue
        $queuesList = $queues->getClient();
        $queue = $queuesList[$queueName];

        // purge it
        //
        // only set the absolute minimum number of parameters that we
        // need to
        $result = $queue->purgeQueue($queue);

        // all done
        return $result;
    }
}