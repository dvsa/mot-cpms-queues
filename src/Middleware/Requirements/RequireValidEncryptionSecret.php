<?php

namespace DVSA\CPMS\Queues\Middleware\Requirements;

use DVSA\CPMS\Queues\Exceptions\E4xx_InvalidEncryptionSecret;
use DVSA\CPMS\Queues\Middleware\Checks\IsValidEncryptionSecret;

class RequireValidEncryptionSecret
{
    /**
     * is the given 'secret' (ie the initialisation vector) valid for the
     * given encryption algorithm?
     *
     * @param  string $encryptionType
     *         the given algorithm to use
     * @param  string $iv
     *         the initialisation vector to check
     * @return void
     * @throws E4xx_InvalidEncryptionType
     *         if the initialisation vector isn't valid for the given
     *         encryption algorithm
     */
    public function __invoke($encryptionType, $iv)
    {
        self::check($encryptionType, $iv);
    }

    /**
     * is the given 'secret' (ie the initialisation vector) valid for the
     * given encryption algorithm?
     *
     * @param  string $encryptionType
     *         the given algorithm to use
     * @param  string $iv
     *         the initialisation vector to check
     * @return void
     * @throws E4xx_InvalidEncryptionType
     *         if the initialisation vector isn't valid for the given
     *         encryption algorithm
     */
    public static function check($encryptionType, $iv)
    {
        if (IsValidEncryptionSecret::check($encryptionType, $iv)) {
            return;
        }

        throw new E4xx_InvalidEncryptionSecret($encryptionType, $iv);
    }
}