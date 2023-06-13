<?php

namespace DVSA\CPMS\Queues\MultipartMessages\Maps;

use DVSA\CPMS\Queues\MultipartMessages\Maps\MultipartMessageMapper;
use DVSA\CPMS\Queues\MultipartMessages\ValueBuilders\BuildTestMessageV1FromPayload;
use DVSA\CPMS\Queues\MultipartMessages\ValueBuilders\BuildPayloadFromTestMessageV1;
use DVSA\CPMS\Queues\MultipartMessages\Values\TestMessageV1;

/**
 * maps between test messages and their factories
 */
class MapTestMessages extends MultipartMessageMapper
{
    /**
     * a list of which factory to use for which message type
     *
     * @var array
     */
    protected $messageTypes = [
        "TEST-MESSAGE-v1" => BuildTestMessageV1FromPayload::class,
    ];

    /**
     * a list of which factory to use for which entity
     *
     * @var array
     */
    protected $entities = [
        TestMessageV1::class => BuildPayloadFromTestMessageV1::class,
    ];
}