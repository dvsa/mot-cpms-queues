<?php

namespace DVSA\CPMS\Queues\Exceptions;

use Exception;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass DVSA\CPMS\Queues\Exceptions\E4xx_InvalidMessageFormat
 */
class E4xx_InvalidMessageFormatTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanInstantiate()
    {
        // ----------------------------------------------------------------
        // setup your test

        $message = "part1part2";

        // ----------------------------------------------------------------
        // perform the change

        $obj = new E4xx_InvalidMessageFormat($message);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(E4xx_InvalidMessageFormat::class, $obj);
    }

    /**
     * @covers ::__construct
     */
    public function testIsException()
    {
        // ----------------------------------------------------------------
        // setup your test

        $message = "part1part2";

        // ----------------------------------------------------------------
        // perform the change

        $obj = new E4xx_InvalidMessageFormat($message);

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

        $message = "part1part2";
        $expectedCode = 400;

        // ----------------------------------------------------------------
        // perform the change

        $obj = new E4xx_InvalidMessageFormat($message);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedCode, $obj->getCode());
    }

}