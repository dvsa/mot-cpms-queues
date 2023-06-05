<?php

namespace DVSA\CPMS\Queues\Ids\ValueBuilders;

use DVSA\CPMS\Queues\Exceptions\E5xx_CannotGenerateMessageId;
use Exception;
use Ramsey\Uuid\Uuid;

/**
 * utility class for generating unique IDs for queue messages
 */
class GenerateMessageId
{
    /**
     * generate a new message ID
     *
     * @return string
     *         the message ID as a printable ASCII string
     */
    public function __invoke()
    {
        return self::now();
    }

    /**
     * generate a new message ID
     *
     * @return string
     *         the message ID as a printable ASCII string
     */
    public static function now()
    {
        try {
            $id = Uuid::uuid1();
            return $id->toString();
        }
        catch (Exception $e) {
            throw new E5xx_CannotGenerateMessageId($e->getMessage());
        }
    }
}