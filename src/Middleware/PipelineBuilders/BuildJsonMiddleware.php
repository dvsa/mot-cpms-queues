<?php

namespace DVSA\CPMS\Queues\Middleware\PipelineBuilders;

use DVSA\CPMS\Queues\Middleware\Interfaces\MiddlewareBuilder;
use DVSA\CPMS\Queues\Middleware\PayloadEditors\JsonDecodePayload;
use DVSA\CPMS\Queues\Middleware\PayloadEditors\JsonEncodePayload;

class BuildJsonMiddleware implements MiddlewareBuilder
{
    /**
     * create the encoder / decoder pair for converting to and from JSON
     *
     * @param  array $config
     *         the config to use for this middleware
     * @return array
     *         the encoder / decoder pair
     */
    public function __invoke($config)
    {
        return self::from($config);
    }

    /**
     * create the encoder / decoder pair for converting to and from JSON
     *
     * @param  array $config
     *         the config to use for this middleware
     * @return array
     *         the encoder / decoder pair
     */
    public static function from($config)
    {
        $retval = [
            'Encoder' => new JsonEncodePayload(),
            'Decoder' => new JsonDecodePayload()
        ];

        return $retval;
    }
}