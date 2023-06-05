<?php

namespace DVSA\CPMS\Queues\QueueAdapters\Interfaces;

use DVSA\CPMS\Queues\Exceptions\E4xx_NoSuchQueueConfigured;
use DVSA\CPMS\Queues\QueueAdapters\Values\QueueMessage;

/**
 * Interface Queues
 * @package DVSA\CPMS\Queues\QueueAdapters\Interfaces
 */
interface Queues
{
    /**
     * return the underlying client used to interface with the queue(s)
     *
     * @return object
     *         the underlying client
     */
    public function getClient();

    /**
     * get the config settings for a given queue
     *
     * @param  string $queueName
     *         the name of the queue we want
     * @return array
     *         the config settings for the queue
     *
     * @throws E4xx_NoSuchQueueConfigured
     *         if the queue has not been configured
     */
    public function getQueueConfig($queueName);

    /**
     * how do we read messages from these queues?
     *
     * @return MessageReader
     */
    public function getMessageReader();

    /**
     * how do we write messages to these queues
     *
     * @return MessageWriter
     */
    public function getMessageWriter();

    /**
     * how do we confirm that a message has been processed?
     *
     * @return MessageConfirmer
     */
    public function getMessageConfirmer();

    /**
     * how do we inspect the queue to see how many messages it contains?
     *
     * @return QueueLengthInspector
     */
    public function getQueueLengthInspector();

    /**
     * how do we encode the message that is going onto the queue?
     *
     * @return array<PayloadEncoder>
     */
    public function getQueueEncoders($queueName);

    /**
     * how do we decode the message that is going onto the queue?
     *
     * @return array<PayloadDecoder>
     */
    public function getQueueDecoders($queueName);

    // ==================================================================
    //
    // Helpers
    //
    // These provide a more traditional interface to the message
    // reader, writer and confirmer objects
    //
    // ------------------------------------------------------------------

    /**
     * retrieve 1 or more messages from the named queue
     *
     * @param  string  $queueName
     *         the name of the queue that we want to read from
     * @return array
     *         a list of the retrieved messages
     */
    public function receiveMessagesFromQueue($queueName);

    /**
     * write a message to a queue
     *
     * @param  string $queueName
     *         the name of the queue to write to
     * @param  string $message
     *         the message to write
     * @return object
     *         the metadata about the successfully written message
     */
    public function writeMessageToQueue($queueName, $message);

    /**
     * confirm that a message can be dropped from the queue that it
     * came from
     *
     * @param  QueueMessage $message
     *         the message that we're done with
     * @return void
     */
    public function confirmMessageHandled(QueueMessage $message);

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
     * @return int
     *         the number of messages waiting in the queue
     */
    public function getNumberOfMessagesInQueue($queueName);


    /**
     * purge the queue
     *
     * @param string $queueName
     *        the name of the queue to purge
     */
    public function getQueuePurger();
}