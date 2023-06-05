<?php

namespace DVSA\CPMS\Queues\Exceptions;

use Exception;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass DVSA\CPMS\Queues\Exceptions\E4xx_UnsupportedEntityType
 */
class E4xx_UnsupportedEntityTypeTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanInstantiate()
    {
        // ----------------------------------------------------------------
        // setup your test

        $className = "stdClass";

        // ----------------------------------------------------------------
        // perform the change

        $obj = new E4xx_UnsupportedEntityType($className);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(E4xx_UnsupportedEntityType::class, $obj);
    }

    /**
     * @covers ::__construct
     */
    public function testIsException()
    {
        // ----------------------------------------------------------------
        // setup your test

        $className = "stdClass";

        // ----------------------------------------------------------------
        // perform the change

        $obj = new E4xx_UnsupportedEntityType($className);

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

        $className = "stdClass";
        $expectedCode = 400;

        // ----------------------------------------------------------------
        // perform the change

        $obj = new E4xx_UnsupportedEntityType($className);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedCode, $obj->getCode());
    }

}