<?php

namespace DVSA\CPMS\Queues\Exceptions;

use Exception;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass DVSA\CPMS\Queues\Exceptions\E4xx_UnsupportedHmacType
 */
class E4xx_UnsupportedHmacTypeTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanInstantiate()
    {
        // ----------------------------------------------------------------
        // setup your test

        $type = "trout";

        // ----------------------------------------------------------------
        // perform the change

        $obj = new E4xx_UnsupportedHmacType($type);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(E4xx_UnsupportedHmacType::class, $obj);
    }

    /**
     * @covers ::__construct
     */
    public function testIsException()
    {
        // ----------------------------------------------------------------
        // setup your test

        $type = "trout";

        // ----------------------------------------------------------------
        // perform the change

        $obj = new E4xx_UnsupportedHmacType($type);

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

        $type = "trout";
        $expectedCode = 400;

        // ----------------------------------------------------------------
        // perform the change

        $obj = new E4xx_UnsupportedHmacType($type);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedCode, $obj->getCode());
    }

}