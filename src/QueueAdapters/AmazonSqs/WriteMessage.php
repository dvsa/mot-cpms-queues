<?php

namespace DVSA\CPMS\Queues\QueueAdapters\AmazonSqs;

use DVSA\CPMS\Queues\QueueAdapters\Interfaces\MessageWriter;
use DVSA\CPMS\Queues\QueueAdapters\Interfaces\PayloadEncoder;
use DVSA\CPMS\Queues\QueueAdapters\Interfaces\Queues;

class WriteMessage implements MessageWriter
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
    public function __invoke($queueName, Queues $queues, $message)
    {
        return self::to($queueName, $queues, $message);
    }

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
    public static function to($queueName, Queues $queues, $message)
    {
        // we need this to write to the queue
        $client = $queues->getClient();
        $queueConfig = $queues->getQueueConfig($queueName);
        $encoders = $queues->getQueueEncoders($queueName);

        // convert the message that we're going to send
        $message = self::applyEncoders($message, $encoders);

        // write the final message
        //
        // only set the absolute minimum number of parameters that we
        // need to
        $result = $client->sendMessage([
            'MessageBody' => (string)$message,
            'QueueUrl' => $queueConfig['QueueUrl'],
        ]);

        // @var \Aws\Result
        return $result;
    }

    /**
     * apply zero or more message encoders to our message
     *
     * this was originally added to support encrypting data
     *
     * @param  string $message
     *         the message to modify
     * @param  array<PayloadEncoder> $encoders
     *         the list of encoders to apply
     * @return string
     *         the modified message
     */
    private static function applyEncoders($message, $encoders)
    {
        // our return value
        $retval = $message;

        // apply the list, if there is anything in it
        foreach ($encoders as $encoder) {
            // the encoder returns a new message
            $retval = $encoder($retval);
        }

        // all done
        return $retval;
    }
}