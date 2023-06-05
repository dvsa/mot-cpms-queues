<?php

namespace DVSA\CPMS\Queues\Middleware\PayloadEditors;

use DVSA\CPMS\Queues\Exceptions\E4xx_CannotEncodeMessagePayload;
use DVSA\CPMS\Queues\Middleware\Interfaces\PayloadEncoder;

class Base64EncodePayload implements PayloadEncoder
{
    /**
     * encode the contents of a message
     *
     * @param  string $payload
     *         the payload to be modified
     * @return string
     *         the modified payload
     */
    public function __invoke($payload)
    {
        // we only operate on strings
        if (!is_string($payload)) {
            throw new E4xx_CannotEncodeMessagePayload(var_export($payload, true), "payload must be string");
        }

        // encode the payload
        //
        // this helps if you're sending binary data (e.g. encrypted data)
        // to a queueing system that doesn't accept binary data (e.g. SQS)
        $newPayload = base64_encode($payload);

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
        return 'Base64';
    }
}