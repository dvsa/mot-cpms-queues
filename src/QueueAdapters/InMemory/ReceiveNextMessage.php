<?php

namespace DVSA\CPMS\Queues\QueueAdapters\InMemory;

use DVSA\CPMS\Queues\QueueAdapters\Interfaces\MessageReader;
use DVSA\CPMS\Queues\QueueAdapters\Interfaces\Queues;
use DVSA\CPMS\Queues\QueueAdapters\Values\QueueMessage;
use DVSA\CPMS\Queues\QueueAdapters\Values\UnexpectedPayload;

class ReceiveNextMessage implements MessageReader
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
    public function __invoke($queueName, Queues $queues)
    {
        return self::from($queueName, $queues);
    }

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
    public static function from($queueName, Queues $queues)
    {
        // we need this to read from the queue
        $queuesList = $queues->getClient();
        $queueConfig = $queues->getQueueConfig($queueName);
        $decoders = $queues->getQueueDecoders($queueName);

        // the queue we are going to work with
        $queue = $queuesList[$queueName];

        // get the messages
        $result = $queue->readMessages($queueConfig['MaxNumberOfMessages']);

        // our return value
        $retval = [];
        foreach ($result as $message) {
            $message['QueueName'] = $queueName;
            $qMessage = new QueueMessage(
                $message['body'],
                $message
            );
            $retval[] = self::applyDecoders($qMessage, $decoders);
        }

        // all done
        return $retval;
    }

    /**
     * apply zero or more message decoders to our retrieved message
     *
     * this was originally added to support decrypting data
     *
     * @param  QueueMessage $message
     *         the message to modify
     * @param  array<PayloadDecoder> $decoders
     *         the list of decoders to apply
     * @return QueueMessage
     *         the modified message
     */
    private static function applyDecoders(QueueMessage $qMessage, $decoders)
    {
        // keep track of what each piece of middleware did
        $steps = [];

        // the data to decode
        $payload = $qMessage->getPayload();

        // apply the list, if there is anything in it
        foreach ($decoders as $decoder) {
            // we want to record what happened, to help with troubleshooting
            // and debugging
            $step = [
                'decoder' => $decoder,
                'input' => $payload,
            ];

            try {
                // the decoder returns a new message
                $payload = $decoder($payload);
            }
            catch (\Exception $e) {
                // we can go no further
                //
                // we can't let the exception propagate, because that will
                // force any 'good' messages in this batch to be delayed too
                //
                // and there's no way we're going to silently swallow the
                // error
                $error = $e->getMessage();
                $steps[$decoder->getMiddlewareName()] = $error;

                $failedPayload = new UnexpectedPayload($qMessage->getPayload(), $steps, $error);

                return new QueueMessage($failedPayload, $qMessage->getMetadata(), $steps);
            }

            // remember the new message
            $step['output'] = $payload;

            // track everything
            $steps[$decoder->getMiddlewareName()] = $step;
        }

        // all done
        return new QueueMessage($payload, $qMessage->getMetadata(), $steps);
    }
}