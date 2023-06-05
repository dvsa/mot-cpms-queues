<?php

namespace DVSA\CPMS\Queues\Exceptions;

use RuntimeException;

/**
 * thrown when we've been given an encryption 'secret' (ie an initialisation
 * vector) that isn't the correct length for the given encryption algorithm
 */
class E4xx_InvalidEncryptionSecret extends RuntimeException
{
    /**
     * @param string $encryptionType
     *        the encryption algorithm that you're trying to use
     * @param string $secret
     *        the invalid encryption secret
     */
    public function __construct($encryptionType, $secret)
    {
        $secretLen = strlen($secret);
        $requiredLen = openssl_cipher_iv_length($encryptionType);

        $msg = "encryption algorithm '{$encryptionType}' requires a 'secret' of length {$requiredLen}; your secret is '{$secretLen}' bytes long";
        parent::__construct($msg, 400);
    }
}