<?php

namespace DVSA\CPMS\Queues\Middleware\PipelineBuilders;

use DVSA\CPMS\Queues\Middleware\Interfaces\MiddlewareBuilder;
use DVSA\CPMS\Queues\Middleware\PayloadEditors\Base64DecodePayload;
use DVSA\CPMS\Queues\Middleware\PayloadEditors\Base64EncodePayload;

class BuildBase64Middleware implements MiddlewareBuilder
{
    /**
     * create the encoder / decoder pair for converting binary strings into
     * base64
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
     * create the encoder / decoder pair for converting binary strings into
     * base64
     *
     * @param  array $config
     *         the config to use for this middleware
     * @return array
     *         the encoder / decoder pair
     */
    public static function from($config)
    {
        $retval = [
            'Encoder' => new Base64EncodePayload(),
            'Decoder' => new Base64DecodePayload()
        ];

        return $retval;
    }
}