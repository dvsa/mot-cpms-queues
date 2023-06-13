<?php

namespace DVSA\CPMS\Queues\Middleware\PipelineBuilders;

use DVSA\CPMS\Queues\Middleware\Interfaces\MiddlewareBuilder;
use DVSA\CPMS\Queues\Middleware\PayloadEditors\DecryptPayload;
use DVSA\CPMS\Queues\Middleware\PayloadEditors\EncryptPayload;
use DVSA\CPMS\Queues\Middleware\Requirements\RequireConfigAsArray;
use DVSA\CPMS\Queues\Middleware\Requirements\RequireConfigContainsKey;

class BuildEncryptionMiddleware implements MiddlewareBuilder
{
    /**
     * create the encoder / decoder pair for encrypted message support
     *
     * config items!!
     * - type - the OpenSSL cipher to use
     * - key - the encryption key to use
     * - secret - the initialisation vector to use
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
     * create the encoder / decoder pair for encrypted message support
     *
     * config items!!
     * - type - the OpenSSL cipher to use
     * - key - the encryption key to use
     * - secret - the initialisation vector to use
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
        RequireConfigContainsKey::check($config, 'secret');

        // if we get here, we're good to go
        $retval = [
            'Encoder' => new EncryptPayload($config['type'], $config['key'], $config['secret']),
            'Decoder' => new DecryptPayload($config['type'], $config['key'], $config['secret'])
        ];

        return $retval;
    }
}