<?php

namespace DVSA\CPMS\Queues\Middleware\PayloadEditors;

use DVSA\CPMS\Queues\Middleware\Interfaces\PayloadEncoder;
use DVSA\CPMS\Queues\Middleware\Requirements\RequireValidHmacType;

class HmacSignPayload implements PayloadEncoder
{
    /**
     * the hashing algorithm to use
     *
     * this is the $algo parameter for hash_hmac()
     *
     * @var string
     */
    private $hashType;

    /**
     * the hash key to use
     *
     * @var string
     */
    private $hashKey;

    /**
     * create our signing middleware
     *
     * @param string $hashType
     *        the hash algorithm to use
     * @param string $hashKey
     *        the shared secret key
     */
    public function __construct($hashType, $hashKey)
    {
        // robustness!
        RequireValidHmacType::check($hashType);

        // if we get here, all is well
        $this->hashType = $hashType;
        $this->hashKey = $hashKey;
    }

    /**
     * sign the contents of a message
     *
     * @param  string $message
     *         the message to be modified
     * @return string
     *         the modified message
     */
    public function __invoke($message)
    {
        // encrypt the message
        $newMessage = hash_hmac($this->hashType, $message, $this->hashKey) . '::' . $message;

        // all done
        return $newMessage;
    }

    /**
     * what is the name of config key, in the overall 'Middleware' section
     * of the config?
     *
     * @return string
     */
    public function getMiddlewareName()
    {
        return 'Hmac';
    }
}