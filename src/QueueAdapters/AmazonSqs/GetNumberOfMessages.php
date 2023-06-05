<?php

namespace DVSA\CPMS\Queues\QueueAdapters\AmazonSqs;

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
        $client = $queues->getClient();
        $queueConfig = $queues->getQueueConfig($queueName);

        // write it
        //
        // only set the absolute minimum number of parameters that we
        // need to
        $result = $client->getQueueAttributes([
            'AttributeNames' => [
                'ApproximateNumberOfMessages',
            ],
            'QueueUrl' => $queueConfig['QueueUrl'],
        ]);

        // what do we have?
        if (!isset($result['Attributes'], $result['Attributes']['ApproximateNumberOfMessages'])) {
            throw new E4xx_CannotInspectQueue($queueName);
        }

        return $result['Attributes']['ApproximateNumberOfMessages'];
    }
}