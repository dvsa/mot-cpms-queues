<?php

namespace DVSA\CPMS\Queues\QueueAdapters\InMemory;

/**
 * a fake queue, held entirely in memory
 *
 * NOTE that we cannot use the SqlQueue
 */
class InMemoryQueue
{
    /**
     * our actual data
     *
     * @var array
     */
    private $data = [];

    /**
     * read up to X number of messages from the front of the queue
     *
     * @param  int $maxRequested
     *         the number of messages to read
     * @return array
     */
    public function readMessages($maxRequested = 1)
    {
        // do we have any messages?
        if (count($this->data) === 0) {
            return [];
        }

        // make sure we do not try to go beyond the end of the queue
        $noToRead = min($maxRequested, count($this->data));

        // our return value
        $retval = [];

        // read from the front of the queue
        //
        // this WILL return 'duplicates' if previously read messages
        // have not yet been deleted
        reset($this->data);
        while ($noToRead) {
            $retval[] = [
                "messageId" => key($this->data),
                "body" => current($this->data),
            ];
            next($this->data);
            $noToRead--;
        }

        // all done
        return $retval;
    }

    /**
     * add a message to the queue
     *
     * @param  string $message
     *         the message to add to the end of the queue
     * @return mixed
     *         something that represents the result of writing to the queue
     *         treat as opaque for now!
     */
    public function writeMessage($message)
    {
        $this->data[] = $message;
        end($this->data);
        return key($this->data);
    }

    /**
     * remove a message from the queue
     *
     * @param  int $messageId
     *         the messageId provided when you called readMessage()
     * @return void
     */
    public function deleteMessage($messageId)
    {
        if (isset($this->data[$messageId])) {
            unset($this->data[$messageId]);
        }
    }

    /**
     * remove all message from the queue
     *
     * @return void
     */
    public function purgeQueue()
    {
        $this->data = [];
    }

    /**
     * how many messages are in the queue?
     *
     * @return int
     */
    public function getQueueLength()
    {
        return count($this->data);
    }


}