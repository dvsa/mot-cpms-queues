<?php

namespace DVSA\CPMS\Queues\Middleware\Checks;

class IsValidEncryptionSecret
{
    /**
     * is the given 'secret' (ie the initialisation vector) valid for the
     * given encryption algorithm?
     *
     * @param  string $encryptionType
     *         the given algorithm to use
     * @param  string $iv
     *         the initialisation vector to check
     * @return boolean
     *         TRUE if it is valid
     *         FALSE otherwise
     */
    public function __invoke($encryptionType, $iv)
    {
        return self::check($encryptionType, $iv);
    }

    /**
     * is the given 'secret' (ie the initialisation vector) valid for the
     * given encryption algorithm?
     *
     * @param  string $encryptionType
     *         the given algorithm to use
     * @param  string $iv
     *         the initialisation vector to check
     * @return boolean
     *         TRUE if it is valid
     *         FALSE otherwise
     */
    public static function check($encryptionType, $iv)
    {
        $requiredLen = openssl_cipher_iv_length($encryptionType);

        return (strlen($iv) === $requiredLen);
    }
}