<?php

namespace DVSA\CPMS\Queues\Middleware\Requirements;

use DVSA\CPMS\Queues\Exceptions\E4xx_UnsupportedHmacType;
use DVSA\CPMS\Queues\Middleware\Checks\IsValidHmacType;

class RequireValidHmacType
{
    /**
     * is the given hmac algorithm supported by this version of PHP?
     *
     * @param  string $hmacType
     *         the algorithm to check
     * @return void
     * @throws E4xx_UnsupportedHmacType
     *         if the algorithm isn't supported by this version of PHP
     */
    public function __invoke($hmacType)
    {
        self::check($hmacType);
    }

    /**
     * is the given hmac algorithm supported by this version of PHP?
     *
     * @param  string $hmacType
     *         the algorithm to check
     * @return void
     * @throws E4xx_UnsupportedHmacType
     *         if the algorithm isn't supported by this version of PHP
     */
    public static function check($hmacType)
    {
        if (IsValidHmacType::check($hmacType)) {
            return;
        }

        throw new E4xx_UnsupportedHmacType($hmacType);
    }
}