<?php

namespace DVSA\CPMS\Queues\Middleware\Requirements;

use DVSA\CPMS\Queues\Exceptions\E4xx_ConfigKeyMustContainClassName;
use DVSA\CPMS\Queues\Exceptions\E4xx_ConfigKeyMustContainString;

class RequireConfigKeyContainsClassName
{
    /**
     * is the given config key a PHP classname, does the class exist?
     *
     * @param  array|object $config
     *         the config to check
     * @param  string|int $key
     *         the config item to check for
     * @return void
     * @throws E4xx_ConfigKeyMustContainString
     * @throws E4xx_ConfigKeyMustContainClassName
     *         if $key's value is not a valid PHP class name
     */
    public function __invoke($config, $key)
    {
        self::check($config, $key);
    }

    /**
     * is the given config key a PHP classname, does the class exist?
     *
     * @param  array|object $config
     *         the config to check
     * @param  string|int $key
     *         the config item to check for
     * @return void
     * @throws E4xx_ConfigKeyMustContainString
     * @throws E4xx_ConfigKeyMustContainClassName
     *         if $key's value is not a valid PHP class name
     */
    public static function check($config, $key)
    {
        $classname = $config[$key];
        if (!is_string($classname)) {
            throw new E4xx_ConfigKeyMustContainString($key);
        }
        if (!class_exists($classname)) {
            throw new E4xx_ConfigKeyMustContainClassName($key, $classname);
        }
    }
}