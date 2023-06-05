<?php

namespace DVSA\CPMS\Queues\Middleware\Requirements;

use DVSA\CPMS\Queues\Exceptions\E4xx_UnsupportedEncryptionType;
use DVSA\CPMS\Queues\Middleware\Checks\IsValidEncryptionType;

class RequireValidEncryptionType
{
    /**
     * is the given encryption algorithm supported by this version of PHP?
     *
     * @param  string $encryptionType
     *         the algorithm to check
     * @return void
     * @throws E4xx_UnsupportedEncryptionType
     *         if the algorithm isn't supported by this version of PHP
     */
    public function __invoke($encryptionType)
    {
        self::check($encryptionType);
    }

    /**
     * is the given encryption algorithm supported by this version of PHP?
     *
     * @param  string $encryptionType
     *         the algorithm to check
     * @return void
     * @throws E4xx_UnsupportedEncryptionType
     *         if the algorithm isn't supported by this version of PHP
     */
    public static function check($encryptionType)
    {
        if (IsValidEncryptionType::check($encryptionType)) {
            return;
        }

        throw new E4xx_UnsupportedEncryptionType($encryptionType);
    }
}