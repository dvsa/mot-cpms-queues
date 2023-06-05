<?php

namespace DVSA\CPMS\Queues\Exceptions;

use Exception;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass DVSA\CPMS\Queues\Exceptions\E4xx_CannotDecryptMessagePayload
 */
class E4xx_CannotDecryptMessagePayloadTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanInstantiate()
    {
        // ----------------------------------------------------------------
        // setup your test

        $reason  = "test case";

        // ----------------------------------------------------------------
        // perform the change

        $obj = new E4xx_CannotDecryptMessagePayload($reason);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(E4xx_CannotDecryptMessagePayload::class, $obj);
    }

    /**
     * @covers ::__construct
     */
    public function testIsException()
    {
        // ----------------------------------------------------------------
        // setup your test

        $reason  = "test case";

        // ----------------------------------------------------------------
        // perform the change

        $obj = new E4xx_CannotDecryptMessagePayload($reason);

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

        $reason  = "test case";
        $expectedCode = 400;

        // ----------------------------------------------------------------
        // perform the change

        $obj = new E4xx_CannotDecryptMessagePayload($reason);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedCode, $obj->getCode());
    }
}