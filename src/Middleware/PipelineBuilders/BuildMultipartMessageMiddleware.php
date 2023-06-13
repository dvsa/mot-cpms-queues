<?php

namespace DVSA\CPMS\Queues\Middleware\PipelineBuilders;

use DVSA\CPMS\Queues\Exceptions\E4xx_ConfigKeyMustContainClassNameOfType;
use DVSA\CPMS\Queues\Middleware\Interfaces\MiddlewareBuilder;
use DVSA\CPMS\Queues\Middleware\PayloadEditors\BuildMultipartMessageFromPayload;
use DVSA\CPMS\Queues\Middleware\PayloadEditors\BuildPayloadFromMultipartMessage;
use DVSA\CPMS\Queues\Middleware\Requirements\RequireConfigAsArray;
use DVSA\CPMS\Queues\Middleware\Requirements\RequireConfigContainsKey;
use DVSA\CPMS\Queues\Middleware\Requirements\RequireConfigKeyContainsClassName;
use DVSA\CPMS\Queues\MultipartMessages\Maps\MultipartMessageMapper;

class BuildMultipartMessageMiddleware implements MiddlewareBuilder
{
    /**
     * create the encoder / decoder pair for converting value objects into
     * multipart messages
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
     * create the encoder / decoder pair for converting value objects into
     * multipart messages
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
        RequireConfigContainsKey::check($config, 'mapper');
        RequireConfigKeyContainsClassName::check($config, 'mapper', MultipartMessageMapper::class);

        // create our mapper
        $mapper = new $config['mapper']();

        // moar robustness!
        if (!$mapper instanceof MultipartMessageMapper) {
            throw new E4xx_ConfigKeyMustContainClassNameOfType('mapper', $config['mapper'], MultipartMessageMapper::class);
        }

        $retval = [
            'Encoder' => new BuildPayloadFromMultipartMessage($mapper),
            'Decoder' => new BuildMultipartMessageFromPayload($mapper),
        ];

        return $retval;
    }
}