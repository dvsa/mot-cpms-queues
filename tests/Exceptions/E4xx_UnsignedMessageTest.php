<?php

namespace DVSA\CPMS\Queues\Exceptions;

use Exception;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass DVSA\CPMS\Queues\Exceptions\E4xx_UnsignedMessage
 */
class E4xx_UnsignedMessageTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanInstantiate()
    {
        // ----------------------------------------------------------------
        // setup your test

        $message = "hello, world!";

        // ----------------------------------------------------------------
        // perform the change

        $obj = new E4xx_UnsignedMessage($message);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(E4xx_UnsignedMessage::class, $obj);
    }

    /**
     * @covers ::__construct
     */
    public function testIsException()
    {
        // ----------------------------------------------------------------
        // setup your test

        $message = "hello, world!";

        // ----------------------------------------------------------------
        // perform the change

        $obj = new E4xx_UnsignedMessage($message);

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

        $message = "hello, world!";
        $expectedCode = 400;

        // ----------------------------------------------------------------
        // perform the change

        $obj = new E4xx_UnsignedMessage($message);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedCode, $obj->getCode());
    }

}