<?php

namespace DVSA\CPMS\Queues\Exceptions;

use RuntimeException;

/**
 * thrown when a required config setting is missing
 */
class E4xx_MissingConfigSetting extends RuntimeException
{
    /**
     * @param array $config
     *        the config where the entry is missing from
     * @param string|int $key
     *        the name of the missing config entry
     */
    public function __construct($config, $key)
    {
        $printableConfig = var_export($config, true);

        $msg = "missing config setting '{$key}' in config '{$printableConfig}'";
        parent::__construct($msg, 400);
    }
}