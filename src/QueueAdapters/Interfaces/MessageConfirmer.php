<?php

namespace DVSA\CPMS\Queues\QueueAdapters\Interfaces;

use DVSA\CPMS\Queues\QueueAdapters\Values\QueueMessage;

interface MessageConfirmer
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
    public static function to(Queues $queues, QueueMessage $message);
}