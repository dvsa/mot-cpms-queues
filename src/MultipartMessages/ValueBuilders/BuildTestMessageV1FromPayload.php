<?php

namespace DVSA\CPMS\Queues\MultipartMessages\ValueBuilders;

use DVSA\CPMS\Queues\MultipartMessages\ValueBuilders\PayloadDecoderFactory;
use DVSA\CPMS\Queues\MultipartMessages\Values\TestMessageV1;

class BuildTestMessageV1FromPayload implements PayloadDecoderFactory
{
    /**
     * builds a Test Message V1 from a decoded JSON data block
     *
     * @param  stdClass $data
     *         the decoded data
     * @return TestMessageV1
     *         the populated entity
     */
    public function __invoke($data)
    {
        return self::from($data);
    }

    /**
     * builds a Test Message V1 from a decoded JSON data block
     *
     * @param  stdClass $data
     *         the decoded data
     * @return TestMessageV1
     *         the populated entity
     */
    public static function from($data)
    {
        return new TestMessageV1(
            $data->origin,
            $data->id,
            $data->greeting
        );
    }
}