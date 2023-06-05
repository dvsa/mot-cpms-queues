<?php

namespace DVSA\CPMS\Queues\Exceptions;

use Exception;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass DVSA\CPMS\Queues\Exceptions\E4xx_CannotDecodeMessagePayload
 */
class E4xx_CannotDecodeMessagePayloadTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanInstantiate()
    {
        // ----------------------------------------------------------------
        // setup your test

        $message = "part1\npart2";
        $reason  = "test case";

        // ----------------------------------------------------------------
        // perform the change

        $obj = new E4xx_CannotDecodeMessagePayload($message, $reason);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(E4xx_CannotDecodeMessagePayload::class, $obj);
    }

    /**
     * @covers ::__construct
     */
    public function testIsException()
    {
        // ----------------------------------------------------------------
        // setup your test

        $message = "part1\npart2";
        $reason  = "test case";

        // ----------------------------------------------------------------
        // perform the change

        $obj = new E4xx_CannotDecodeMessagePayload($message, $reason);

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

        $message = "part1\npart2";
        $reason  = "test case";
        $expectedCode = 400;

        // ----------------------------------------------------------------
        // perform the change

        $obj = new E4xx_CannotDecodeMessagePayload($message, $reason);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedCode, $obj->getCode());
    }
}