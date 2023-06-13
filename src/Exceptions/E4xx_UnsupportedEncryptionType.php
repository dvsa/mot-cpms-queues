<?php

namespace DVSA\CPMS\Queues\Exceptions;

use RuntimeException;

/**
 * thrown when we've been given an encryption algorithm that this version
 * of PHP does not support
 */
class E4xx_UnsupportedEncryptionType extends RuntimeException
{
    /**
     * @param string $encryptionType
     *        the algorithm that this version of PHP does not support
     */
    public function __construct($encryptionType)
    {
        $msg = "encryption algorithm '{$encryptionType}' not supported; available algorithms are: " . implode(',', openssl_get_cipher_methods());
        parent::__construct($msg, 400);
    }
}