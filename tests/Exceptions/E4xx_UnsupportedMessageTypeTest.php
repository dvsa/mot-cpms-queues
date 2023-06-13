<?php

namespace DVSA\CPMS\Queues\Exceptions;

use Exception;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass DVSA\CPMS\Queues\Exceptions\E4xx_UnsupportedMessageType
 */
class E4xx_UnsupportedMessageTypeTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanInstantiate()
    {
        // ----------------------------------------------------------------
        // setup your test

        $messageType = "scheme-notifications";

        // ----------------------------------------------------------------
        // perform the change

        $obj = new E4xx_UnsupportedMessageType($messageType);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(E4xx_UnsupportedMessageType::class, $obj);
    }

    /**
     * @covers ::__construct
     */
    public function testIsException()
    {
        // ----------------------------------------------------------------
        // setup your test

        $messageType = "scheme-notifications";

        // ----------------------------------------------------------------
        // perform the change

        $obj = new E4xx_UnsupportedMessageType($messageType);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(Exception::class, $obj);
    }

    /**
     * @covers ::__construct
     */
    public function testHasErrorCode400()
    {
        // ----------------------------------------------------------------
        // setup your test

        $messageType = "scheme-notifications";
        $expectedCode = 400;

        // ----------------------------------------------------------------
        // perform the change

        $obj = new E4xx_UnsupportedMessageType($messageType);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedCode, $obj->getCode());
    }

}