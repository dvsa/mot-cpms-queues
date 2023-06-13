<?php

namespace DVSA\CPMS\Queues\Middleware\PayloadEditors;

use DVSA\CPMS\Queues\Exceptions\E4xx_CannotDecodeMessagePayload;
use DVSA\CPMS\Queues\Middleware\Interfaces\PayloadDecoder;
use Exception;
use Seld\JsonLint\JsonParser;

class JsonDecodePayload implements PayloadDecoder
{
    /**
     * our JSON parser
     *
     * we use this for the better error handling
     *
     * @var JsonParser
     */
    private $parser;

    /**
     * our constructor
     */
    public function __construct()
    {
        $this->parser = new JsonParser();
    }

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

        // convert the payload into an array or an object
        // if the payload isn't valid JSON, the parser will throw an exception
        try {
            $newPayload = $this->parser->parse($payload);
        }
        catch (Exception $e) {
            throw new E4xx_CannotDecodeMessagePayload($payload, "payload is not valid JSON; error is: " . $e->getMessage());
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
        return 'Json';
    }
}