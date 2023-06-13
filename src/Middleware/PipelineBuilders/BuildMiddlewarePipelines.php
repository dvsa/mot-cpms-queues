<?php

namespace DVSA\CPMS\Queues\Middleware\PipelineBuilders;

use DVSA\CPMS\Queues\Exceptions\E4xx_InvalidMiddlewareBuilder;
use DVSA\CPMS\Queues\Exceptions\E4xx_NoSuchMiddleware;
use DVSA\CPMS\Queues\Middleware\Interfaces\MiddlewareBuilder;

class BuildMiddlewarePipelines
{
    /**
     * build the middleware pipeline from the supplied config
     *
     * @param  array $config
     *         a list of the middleware items to build, with each item's config
     * @return array
     *         the initialised middleware to use
     */
    public function __invoke($config)
    {
        return self::from($config);
    }

    /**
     * build the middleware pipeline from the supplied config
     *
     * @param  array $config
     *         a list of the middleware items to build, with each item's config
     * @return array
     *         the initialised middleware to use
     */
    public static function from($config)
    {
        // we're going to fill this out
        $retval = [
            'Encoders' => [],
            'Decoders' => []
        ];

        // walk the list of middleware items to create
        foreach ($config as $classname => $itemConfig) {
            // we support short names for convenience
            if (!class_exists($classname)) {
                $classname = __NAMESPACE__ . "\\Build" . ucfirst($classname) . 'Middleware';
            }

            // do we have a builder?
            if (!class_exists($classname)) {
                throw new E4xx_NoSuchMiddleware($classname);
            }

            // yes we do - create it
            $middlewareBuilder = new $classname;

            // is the builder valid?
            if (!$middlewareBuilder instanceof MiddlewareBuilder) {
                throw new E4xx_InvalidMiddlewareBuilder($classname);
            }

            // yes it is - use it!
            $middleware = $middlewareBuilder($itemConfig);

            // we assume the list is in the order that data needs encoding
            $retval['Encoders'][] = $middleware['Encoder'];

            // we require that decoding happens in reverse order
            array_unshift($retval['Decoders'], $middleware['Decoder']);
        }

        // all done
        return $retval;
    }
}