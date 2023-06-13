<?php

namespace DVSA\CPMS\Queues\Exceptions;

use Exception;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass DVSA\CPMS\Queues\Exceptions\E4xx_ConfigKeyMustContainClassName
 */
class E4xx_ConfigKeyMustContainClassNameTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanInstantiate()
    {
        // ----------------------------------------------------------------
        // setup your test

        $key = "hello";
        $classname = "world";

        // ----------------------------------------------------------------
        // perform the change

        $obj = new E4xx_ConfigKeyMustContainClassName($key, $classname);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(E4xx_ConfigKeyMustContainClassName::class, $obj);
    }

    /**
     * @covers ::__construct
     */
    public function testIsException()
    {
        // ----------------------------------------------------------------
        // setup your test

        $key = "hello";
        $classname = "world";

        // ----------------------------------------------------------------
        // perform the change

        $obj = new E4xx_ConfigKeyMustContainClassName($key, $classname);

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
        $classname = "world";

        // ----------------------------------------------------------------
        // perform the change

        $obj = new E4xx_ConfigKeyMustContainClassName($key, $classname);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedCode, $obj->getCode());
    }

}