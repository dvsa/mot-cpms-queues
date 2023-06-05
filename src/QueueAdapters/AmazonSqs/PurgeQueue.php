<?php

namespace DVSA\CPMS\Queues\QueueAdapters\AmazonSqs;

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
     *         the metadata about the successfully purged queue
     */
    public function __invoke($queueName, Queues $queues)
    {
        return self::to($queueName, $queues);
    }

    /**
     * purge a queue
     *
     * @param  string $queueName
     *         the name of the queue to purge
     * @param  Queues $queues
     *         our connection to our queues
     * @return object
     *         the metadata about the successfully purged queue
     */
    public static function to($queueName, Queues $queues)
    {
        // we need this to purge the queue
        $client = $queues->getClient();
        $queueConfig = $queues->getQueueConfig($queueName);

        // purge it
        //
        // only set the absolute minimum number of parameters that we
        // need to

        $result = $client->purgeQueue(['QueueUrl' => $queueConfig['QueueUrl'],]);


        // @var \Aws\Result
        return $result;
    }
}