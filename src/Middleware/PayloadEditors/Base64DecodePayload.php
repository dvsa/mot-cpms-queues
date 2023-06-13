<?php

namespace DVSA\CPMS\Queues\Middleware\PayloadEditors;

use DVSA\CPMS\Queues\Exceptions\E4xx_CannotDecodeMessagePayload;
use DVSA\CPMS\Queues\Middleware\Interfaces\PayloadDecoder;

class Base64DecodePayload implements PayloadDecoder
{
    /**
     * modify a message's contents after the message has been read from a queue
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
            throw new E4xx_CannotDecodeMessagePayload(var_export($payload, true), "payload must be string");
        }

        // convert the payload into its original, possibly binary, form
        $newPayload = base64_decode($payload);

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