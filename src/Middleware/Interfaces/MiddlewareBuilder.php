<?php

namespace DVSA\CPMS\Queues\Middleware\Interfaces;

/**
 * interface implemented by factories that can create encoder / decoder
 * components
 */
interface MiddlewareBuilder
{
    /**
     * build middleware components from their static config
     *
     * @param  array $config
     *         the config to use for this middleware
     * @return array
     *         the encoder / decoder pair
     */
    public function __invoke($config);

    /**
     * build middleware components from their static config
     *
     * @param  array $config
     *         the config to use for this middleware
     * @return array
     *         the encoder / decoder pair
     */
    public static function from($config);
}