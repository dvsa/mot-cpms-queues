<?php

namespace DVSA\CPMS\Queues\Middleware\Checks;

class IsValidEncryptionType
{
    /**
     * is the given encryption algorithm supported by this version of PHP?
     *
     * @param  string $encryptionType
     *         the algorithm to check
     * @return boolean
     *         TRUE if it is supported
     *         FALSE otherwise
     */
    public function __invoke($encryptionType)
    {
        return self::check($encryptionType);
    }

    /**
     * is the given encryption algorithm supported by this version of PHP?
     *
     * @param  string $encryptionType
     *         the algorithm to check
     * @return boolean
     *         TRUE if it is supported
     *         FALSE otherwise
     */
    public static function check($encryptionType)
    {
        // Note that prior to OpenSSL 1.1.1, the cipher methods have been returned in upper case
        // and lower case spelling; as of OpenSSL 1.1.1 only the lower case variants are returned.
        $supportedAlgos = openssl_get_cipher_methods();
        return in_array(strtolower($encryptionType), array_map('strtolower', $supportedAlgos));
    }
}