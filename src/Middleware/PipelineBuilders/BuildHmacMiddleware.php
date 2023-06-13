<?php

namespace DVSA\CPMS\Queues\Middleware\PipelineBuilders;

use DVSA\CPMS\Queues\Middleware\Interfaces\MiddlewareBuilder;
use DVSA\CPMS\Queues\Middleware\PayloadEditors\HmacSignPayload;
use DVSA\CPMS\Queues\Middleware\PayloadEditors\HmacVerifyPayload;
use DVSA\CPMS\Queues\Middleware\Requirements\RequireConfigAsArray;
use DVSA\CPMS\Queues\Middleware\Requirements\RequireConfigContainsKey;

class BuildHmacMiddleware implements MiddlewareBuilder
{
    /**
     * create the encoder / decoder pair for message signing
     *
     * config items!!
     * - type - the hashing algorithm to use
     * - key - the encryption key to use
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
     * create the encoder / decoder pair for message signing
     *
     * config items!!
     * - type - the hashing algorithm to use
     * - key - the encryption key to use
     *
     * @param  array $config
     *         the config to use for this middleware
     * @return array
     *         the encoder / decoder pair
     */
    public static function from($config)
    {
        // robustness!
        RequireConfigAsArray::check($config);
        RequireConfigContainsKey::check($config, 'type');
        RequireConfigContainsKey::check($config, 'key');

        // if we get here, we're good to go
        $retval = [
            'Encoder' => new HmacSignPayload($config['type'], $config['key']),
            'Decoder' => new HmacVerifyPayload($config['type'], $config['key'])
        ];

        return $retval;
    }
}