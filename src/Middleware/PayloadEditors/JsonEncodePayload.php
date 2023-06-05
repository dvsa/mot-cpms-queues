<?php

namespace DVSA\CPMS\Queues\Middleware\PayloadEditors;

use DVSA\CPMS\Queues\Exceptions\E4xx_CannotEncodeMessagePayload;
use DVSA\CPMS\Queues\Middleware\Interfaces\PayloadEncoder;

class JsonEncodePayload implements PayloadEncoder
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
        // we only operate on arrays and objects
        if (!is_array($payload) && !is_object($payload)) {
            throw new E4xx_CannotEncodeMessagePayload(var_export($payload, true), "payload must be array or object");
        }

        // encode the payload
        $newPayload = json_encode($payload);

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
        return 'Json';
    }
}