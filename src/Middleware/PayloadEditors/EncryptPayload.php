<?php

namespace DVSA\CPMS\Queues\Middleware\PayloadEditors;

use DVSA\CPMS\Queues\Exceptions\E4xx_CannotEncryptMessagePayload;
use DVSA\CPMS\Queues\Middleware\Interfaces\PayloadEncoder;
use DVSA\CPMS\Queues\Middleware\Requirements\RequireValidEncryptionSecret;
use DVSA\CPMS\Queues\Middleware\Requirements\RequireValidEncryptionType;

class EncryptPayload implements PayloadEncoder
{
    /**
     * the type of encryption to use
     *
     * this is the $method parameter for openssl_encrypt() / openssl_decrypt()
     *
     * @var string
     */
    private $encryptionType;

    /**
     * the encryption key that we need to do the encryption
     *
     * @var string
     */
    private $encryptionKey;

    /**
     * the initialisation vector that we need to do the encryption
     *
     * think of this as a second key, often called 'secret' in configs
     *
     * @var string
     */
    private $iv;

    /**
     * create our encryptor
     *
     * @param string $encryptionType
     *        the type of encryption to use
     * @param string $encryptionKey
     *        the encryption password to use
     * @param string $iv
     *        the initialisation vector to use
     */
    public function __construct($encryptionType, $encryptionKey, $iv)
    {
        // robustness!
        RequireValidEncryptionType::check($encryptionType);
        RequireValidEncryptionSecret::check($encryptionType, $iv);

        // if we get here, then all is well
        $this->encryptionType = $encryptionType;
        $this->encryptionKey = $encryptionKey;
        $this->iv = $iv;
    }

    /**
     * encrypt the contents of a message
     *
     * @param  mixed $payload
     *         the payload to be modified
     * @return string
     *         the modified payload
     */
    public function __invoke($payload)
    {
        // robustness!
        if (!is_string($payload)) {
            throw new E4xx_CannotEncryptMessagePayload("payload is not a string");
        }

        // encrypt the data
        $newPayload = openssl_encrypt(
            $payload,
            $this->encryptionType,
            $this->encryptionKey,
            OPENSSL_RAW_DATA,
            $this->iv
        );

        // all done
        return $newPayload;
    }

    /**
     * what is the name of config key, in the overall 'Middleware' section
     * of the config?
     *
     * @return string
     */
    public function getMiddlewareName()
    {
        return 'Encryption';
    }
}