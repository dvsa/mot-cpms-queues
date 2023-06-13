<?php

namespace DVSA\CPMS\Queues\Middleware\Requirements;

use DVSA\CPMS\Queues\Exceptions\E4xx_MissingConfigSetting;
use GanbaroDigital\Reflection\Checks\IsIndexable;

class RequireConfigContainsKey
{
    /**
     * does the config contain a required config item?
     *
     * @param  array|object $config
     *         the config to check
     * @param  string|int $key
     *         the config item to check for
     * @return void
     * @throws E4xx_MissingConfigSetting
     *         if $key is not set inside $config
     */
    public function __invoke($config, $key)
    {
        self::check($config, $key);
    }

    /**
     * does the config contain a required config item?
     *
     * @param  array|object $config
     *         the config to check
     * @param  string|int $key
     *         the config item to check for
     * @return void
     * @throws E4xx_MissingConfigSetting
     *         if $key is not set inside $config
     */
    public static function check($config, $key)
    {
        if (isset($config[$key])) {
            return;
        }

        throw new E4xx_MissingConfigSetting($config, $key);
    }
}