<?php

namespace DVSA\CPMS\Queues\QueueAdapters\InMemory;

use DVSA\CPMS\Queues\Exceptions\E4xx_NoSuchQueueConfigured;
use DVSA\CPMS\Queues\Middleware\PipelineBuilders\BuildMiddlewarePipelines;
use DVSA\CPMS\Queues\QueueAdapters\Interfaces\MessageConfirmer;
use DVSA\CPMS\Queues\QueueAdapters\Interfaces\MessageReader;
use DVSA\CPMS\Queues\QueueAdapters\Interfaces\MessageWriter;
use DVSA\CPMS\Queues\QueueAdapters\Interfaces\QueuePurger;
use DVSA\CPMS\Queues\QueueAdapters\Interfaces\Queues;
use DVSA\CPMS\Queues\QueueAdapters\Values\QueueMessage;

/**
 * a pure in-memory queue
 *
 * originally built to make it easier to unit-test CPMS
 */
class InMemoryQueues implements Queues
{
    /**
     * our in-memory queues
     * @var InMemoryQueue[]
     */
    private $inMemoryQueues = array();

    /**
     * a list of the queues that we know about
     *
     * for each queue, we support the following settings:
     *
     * MaxNumberOfMessages => how many messages to read (optional)
     * QueueUrl => full URL of the queue (required)
     * WaitTimeSeconds => how long to wait for new messages (optional)
     *
     * @var array
     */
    private $q;

    /**
     * default values for per-queue config settings
     *
     * we inject these into the per-queue config only if they have not
     * been set by the caller
     *
     * @var array
     */
    private $queueDefaults = [
        // retrieve only 1 message from the queue at a time
        'MaxNumberOfMessages' => 1,
        // queues are active by default
        'active' => true,
        // no encoder / decoder middleware
        'Middleware' => [
        ],
    ];

    /**
     * store our encoder / decoder middleware pipelines for each supported queue
     *
     * @var array
     */
    private $middleware = [];

    /**
     * we need the following entries in the config:
     *
     * ['queues'] => a list of the queues to use
     * ['queues'][queue-name]['active'] => boolean // required
     *
     * @param array $config
     *        the config required to connect to our queues
     */
    public function __construct($config)
    {
        // make sure our list of queues has default values set
        $this->q = $this->applyDefaultsToQueues($config['queues']);

        // create the actual queues
        foreach ($this->q as $queueName => $queueConfig) {
            if (isset($queueConfig['active']) && true === $queueConfig['active']) {
                $this->inMemoryQueues[$queueName] = new InMemoryQueue;
            }
        }
    }

    /**
     * make sure that our default values are applied to each queue
     *
     * @param  array $queues
     *         the explicit config for our queues
     * @return array
     *         the updated config for our queues
     */
    private function applyDefaultsToQueues($queues)
    {
        foreach ($queues as $index => $queue) {
            $queue = array_merge($this->queueDefaults, $queue);
            $queues[$index] = $queue;
        }

        return $queues;
    }

    /**
     * return the underlying queues
     *
     * @return InMemoryQueue[]
     *         the underlying queues
     */
    public function getClient()
    {
        return $this->inMemoryQueues;
    }

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
    public function getQueueConfig($queueName)
    {
        if (!isset($this->q[$queueName])) {
            throw new E4xx_NoSuchQueueConfigured($queueName);
        }

        return $this->q[$queueName];
    }

    /**
     * get the list of decoders to use for a given queue
     *
     * @param  string $queueName
     *         the name of the queue we want
     * @return array<PayloadDecode>
     *         the (possibly empty) list of decoders to apply
     */
    public function getQueueDecoders($queueName)
    {
        if (!isset($this->q[$queueName])) {
            throw new E4xx_NoSuchQueueConfigured($queueName);
        }

        if (isset($this->middleware[$queueName]['Decoders'])) {
            return $this->middleware[$queueName]['Decoders'];
        }

        // build the middleware pipelines for this queue
        $this->middleware[$queueName] = BuildMiddlewarePipelines::from($this->q[$queueName]['Middleware']);

        // all done
        return $this->middleware[$queueName]['Decoders'];
    }

    /**
     * get the list of encoders to use for a given queue
     *
     * @param  string $queueName
     *         the name of the queue we want
     * @return array<PayloadEncode>
     *         the (possibly empty) list of encoders to apply
     */
    public function getQueueEncoders($queueName)
    {
        if (!isset($this->q[$queueName])) {
            throw new E4xx_NoSuchQueueConfigured($queueName);
        }

        if (isset($this->middleware[$queueName]['Encoders'])) {
            return $this->middleware[$queueName]['Encoders'];
        }

        // build the middleware pipelines for this queue
        $this->middleware[$queueName] = BuildMiddlewarePipelines::from($this->q[$queueName]['Middleware']);

        // all done
        return $this->middleware[$queueName]['Encoders'];
    }

    /**
     * how do we read messages from these queues?
     *
     * @return MessageReader
     */
    public function getMessageReader()
    {
        return new ReceiveNextMessage;
    }

    /**
     * how do we write messages to these queues
     *
     * @return MessageWriter
     */
    public function getMessageWriter()
    {
        return new WriteMessage;
    }

    /**
     * how do we confirm that a message has been processed?
     *
     * @return MessageConfirmer
     */
    public function getMessageConfirmer()
    {
        return new ConfirmMessageHandled;
    }

    /**
     * how do we inspect the queue to see how many messages it contains?
     *
     * @return QueueLengthInspector
     */
    public function getQueueLengthInspector()
    {
        return new GetNumberOfMessages;
    }

    /**
     * How do we empty a queue
     *
     * @return PurgeQueue
     */
    public function getQueuePurger()
    {
        return new PurgeQueue;
    }

    // ==================================================================
    //
    // Helpers
    //
    // These provide a more traditional interface to interacting with
    // the queues
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
    public function receiveMessagesFromQueue($queueName)
    {
        $reader = $this->getMessageReader();
        return $reader($queueName, $this);
    }

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
    public function writeMessageToQueue($queueName, $message)
    {
        $writer = $this->getMessageWriter();
        return $writer($queueName, $this, $message);
    }

    /**
     * confirm that a message can be dropped from the queue that it
     * came from
     *
     * @param  QueueMessage $message
     *         the message that we're done with
     * @return void
     */
    public function confirmMessageHandled(QueueMessage $message)
    {
        $confirmMessageHandled = $this->getMessageConfirmer();
        $confirmMessageHandled($this, $message);
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
     * @return int
     *         the number of messages waiting in the queue
     */
    public function getNumberOfMessagesInQueue($queueName)
    {
        $queueLengthInspector = $this->getQueueLengthInspector();
        return $queueLengthInspector($queueName, $this);
    }


    /**
     * purge the queue
     *
     * @param string $queueName
     *        the name of the queue to inspect
     * @return null
     *
     */
    public function purgeQueue($queueName)
    {
        $queuePurger = $this->getQueuePurger();
        return $queuePurger($queueName, $this);

    }
}