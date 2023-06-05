<?php

namespace DVSA\CPMS\Queues\QueueAdapters\AmazonSqs;

use DVSA\CPMS\Queues\QueueAdapters\Interfaces\MessageConfirmer;
use DVSA\CPMS\Queues\QueueAdapters\Interfaces\Queues;
use DVSA\CPMS\Queues\QueueAdapters\Values\QueueMessage;

class ConfirmMessageHandled implements MessageConfirmer
{
    /**
     * confirm that a message can be dropped from the queue that it
     * came from
     *
     * @param  Queues       $queues
     *         our connection to our queues
     * @param  QueueMessage $message
     *         the message that we're done with
     * @return void
     */
    public function __invoke(Queues $queues, QueueMessage $message)
    {
        return self::to($queues, $message);
    }

    /**
     * confirm that a message can be dropped from the queue that it
     * came from
     *
     * @param  Queues       $queues
     *         our connection to our queues
     * @param  QueueMessage $message
     *         the message that we're done with
     * @return void
     */
    public static function to(Queues $queues, QueueMessage $message)
    {
        // we need this to work with the queue
        $client = $queues->getClient();
        $metadata = $message->getMetadata($message);
        $queueUrl = $metadata['QueueUrl'];

        // delete the message
        $client->deleteMessage([
            'QueueUrl' => $queueUrl,
            'ReceiptHandle' => $metadata['ReceiptHandle'],
        ]);

        // all done
    }
}