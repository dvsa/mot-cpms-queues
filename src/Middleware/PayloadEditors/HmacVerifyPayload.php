<?php

namespace DVSA\CPMS\Queues\Middleware\PayloadEditors;

use DVSA\CPMS\Queues\Exceptions\E4xx_UnsignedMessage;
use DVSA\CPMS\Queues\Exceptions\E4xx_UnverifiedMessage;
use DVSA\CPMS\Queues\Middleware\Interfaces\PayloadDecoder;
use DVSA\CPMS\Queues\Middleware\Requirements\RequireValidHmacType;
use DVSA\CPMS\Queues\QueueAdapters\Values\QueueMessage;

class HmacVerifyPayload implements PayloadDecoder
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
        // robustness!!
        RequireValidHmacType::check($hashType);

        // if we get here, then all is well
        $this->hashType = $hashType;
        $this->hashKey = $hashKey;
    }

    /**
     * verify the contents of a message
     *
     * @param  mixed $payload
     *         the contents to be modified
     * @return mixed
     *         the modified contents
     */
    public function __invoke($payload)
    {
        // extract the original signature
        $parts = explode("::", $payload);
        if (count($parts) === 1) {
            // robustness!
            throw new E4xx_UnsignedMessage($payload);
        }
        $expectedHmac = $parts[0];
        $newPayload = substr($payload, strlen($expectedHmac) + 2);

        // verify the signature
        $actualHmac = hash_hmac($this->hashType, $newPayload, $this->hashKey);

        if ($expectedHmac !== $actualHmac) {
            throw new E4xx_UnverifiedMessage($payload, $expectedHmac, $actualHmac);
        }

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
        return 'Hmac';
    }
}