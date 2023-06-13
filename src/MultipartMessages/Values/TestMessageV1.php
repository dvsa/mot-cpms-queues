<?php

namespace DVSA\CPMS\Queues\MultipartMessages\Values;

use DateTime;

class TestMessageV1
{
   /**
     * name of the system which created this message
     * @var string
     */
    private $origin;

    /**
     * unique ID of this message
     * @var string
     */
    private $id;

    /**
     * a text message
     * @var string
     */
    private $greeting;

    public function __construct($origin, $id, $greeting)
    {
        $this->origin = $origin;
        $this->id = $id;
        $this->greeting = $greeting;
    }

    /**
     * which system generated this message?
     *
     * mostly used for testing / debugging purposes
     *
     * @return string
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    /**
     * what is the unique ID of this message?
     *
     * NOTE that this ID is independent of any ID assigned by the underlying
     * queueing system
     *
     * you should treat IDs as opaque
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * what is the text message sent in this test message?
     *
     * @return string
     */
    public function getGreeting()
    {
        return $this->greeting;
    }
}