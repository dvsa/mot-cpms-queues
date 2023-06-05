<?php

namespace DVSA\CPMS\Queues\Middleware\Interfaces;

use DVSA\CPMS\Queues\Middleware\Interfaces\PayloadEncoder;
use DVSA\CPMS\Queues\QueueAdapters\Values\QueueMessage;

/**
 * interface implemented by anything that supports manipulating a message
 * that has been read from a queue
 */
interface PayloadDecoder
{
    /**
     * modify a message's contents after the message has been read from a queue
     *
     * @param  mixed $payload
     *         the contents to be modified
     * @return mixed
     *         the modified contents
     */
    public function __invoke($payload);

    /**
     * what is the name of config key, in the overall 'Middleware' section
     * of the config?
     *
     * @return string
     */
    public function getMiddlewareName();
}