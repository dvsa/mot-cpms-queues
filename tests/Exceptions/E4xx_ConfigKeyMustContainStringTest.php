<?php

namespace DVSA\CPMS\Queues\Exceptions;

use Exception;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass DVSA\CPMS\Queues\Exceptions\E4xx_ConfigKeyMustContainString
 */
class E4xx_ConfigKeyMustContainStringTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanInstantiate()
    {
        // ----------------------------------------------------------------
        // setup your test

        $key = "hello";

        // ----------------------------------------------------------------
        // perform the change

        $obj = new E4xx_ConfigKeyMustContainString($key);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(E4xx_ConfigKeyMustContainString::class, $obj);
    }

    /**
     * @covers ::__construct
     */
    public function testIsException()
    {
        // ----------------------------------------------------------------
        // setup your test

        $key = "hello";

        // ----------------------------------------------------------------
        // perform the change

        $obj = new E4xx_ConfigKeyMustContainString($key);

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

        $expectedCode = 400;
        $key = "hello";

        // ----------------------------------------------------------------
        // perform the change

        $obj = new E4xx_ConfigKeyMustContainString($key);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedCode, $obj->getCode());
    }

}