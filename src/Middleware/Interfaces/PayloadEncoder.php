<?php

namespace DVSA\CPMS\Queues\Middleware\Interfaces;

/**
 * interface implemented by anything that supports manipulating a message
 * that has been read from a queue
 */
interface PayloadEncoder
{
    /**
     * modify a message before it is placed onto a queue
     *
     * @param  string $message
     *         the message to be modified
     * @return string
     *         the modified message
     */
    public function __invoke($message);

    /**
     * what is the name of config key, in the overall 'Middleware' section
     * of the config?
     *
     * @return string
     */
    public function getMiddlewareName();
}