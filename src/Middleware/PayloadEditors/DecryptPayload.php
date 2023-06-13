<?php

namespace DVSA\CPMS\Queues\Middleware\PayloadEditors;

use DVSA\CPMS\Queues\Exceptions\E4xx_CannotDecryptMessagePayload;
use DVSA\CPMS\Queues\Middleware\Interfaces\PayloadDecoder;
use DVSA\CPMS\Queues\Middleware\Requirements\RequireValidEncryptionSecret;
use DVSA\CPMS\Queues\Middleware\Requirements\RequireValidEncryptionType;
use DVSA\CPMS\Queues\QueueAdapters\Values\QueueMessage;

class DecryptPayload implements PayloadDecoder
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
     * the encryption key that we need to do the decryption
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
     * create our decryptor
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
     * decrypt the contents of a message
     *
     * @param  mixed $payload
     *         the contents to be modified
     * @return mixed
     *         the modified contents
     */
    public function __invoke($payload)
    {
        // we only operate on strings
        if (!is_string($payload)) {
            throw new E4xx_CannotDecryptMessagePayload("payload is not a string");
        }

        // decrypt the message
        $newPayload = openssl_decrypt(
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