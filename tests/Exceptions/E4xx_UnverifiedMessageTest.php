<?php

namespace DVSA\CPMS\Queues\Exceptions;

use Exception;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass DVSA\CPMS\Queues\Exceptions\E4xx_UnverifiedMessage
 */
class E4xx_UnverifiedMessageTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanInstantiate()
    {
        // ----------------------------------------------------------------
        // setup your test

        $message = "hello, world!";
        $expectedHmac = "123456";
        $actualHmac = "67890";

        // ----------------------------------------------------------------
        // perform the change

        $obj = new E4xx_UnverifiedMessage($message, $expectedHmac, $actualHmac);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(E4xx_UnverifiedMessage::class, $obj);
    }

    /**
     * @covers ::__construct
     */
    public function testIsException()
    {
        // ----------------------------------------------------------------
        // setup your test

        $message = "hello, world!";
        $expectedHmac = "123456";
        $actualHmac = "67890";

        // ----------------------------------------------------------------
        // perform the change

        $obj = new E4xx_UnverifiedMessage($message, $expectedHmac, $actualHmac);

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
        $expectedHmac = "123456";
        $actualHmac = "67890";
        $expectedCode = 400;

        // ----------------------------------------------------------------
        // perform the change

        $obj = new E4xx_UnverifiedMessage($message, $expectedHmac, $actualHmac);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedCode, $obj->getCode());
    }

}