<?php

namespace DVSA\CPMS\Queues\Middleware\Requirements;

use ArrayAccess;
use DVSA\CPMS\Queues\Exceptions\E4xx_ConfigMustBeAnArray;

class RequireConfigAsArray
{
    /**
     * is the supplied config an array (either a real one, or an object
     * that can pretend to be one)?
     *
     * @param  array|object $config
     *         the item to check
     * @return void
     * @throws E4xx_ConfigMustBeAnArray
     *         if the config is not an array
     */
    public function __invoke($config)
    {
        self::check($config);
    }

    /**
     * is the supplied config an array (either a real one, or an object
     * that can pretend to be one)?
     *
     * @param  array|object $config
     *         the item to check
     * @return void
     * @throws E4xx_ConfigMustBeAnArray
     *         if the config is not an array
     */
    public static function check($config)
    {
        if (is_array($config) || $config instanceof ArrayAccess) {
            return;
        }

        throw new E4xx_ConfigMustBeAnArray();
    }
}