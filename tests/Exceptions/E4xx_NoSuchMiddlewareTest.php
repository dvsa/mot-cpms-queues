<?php

namespace DVSA\CPMS\Queues\Exceptions;

use Exception;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass DVSA\CPMS\Queues\Exceptions\E4xx_NoSuchMiddleware
 */
class E4xx_NoSuchMiddlewareTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanInstantiate()
    {
        // ----------------------------------------------------------------
        // setup your test

        $name = "DVSA\\CPMS\\Queues\\Middleware\\PipelineBuilders\\Trout";

        // ----------------------------------------------------------------
        // perform the change

        $obj = new E4xx_NoSuchMiddleware($name);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(E4xx_NoSuchMiddleware::class, $obj);
    }

    /**
     * @covers ::__construct
     */
    public function testIsException()
    {
        // ----------------------------------------------------------------
        // setup your test

        $name = "DVSA\\CPMS\\Queues\\Middleware\\PipelineBuilders\\Trout";

        // ----------------------------------------------------------------
        // perform the change

        $obj = new E4xx_NoSuchMiddleware($name);

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

        $name = "DVSA\\CPMS\\Queues\\Middleware\\PipelineBuilders\\Trout";
        $expectedCode = 400;

        // ----------------------------------------------------------------
        // perform the change

        $obj = new E4xx_NoSuchMiddleware($name);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedCode, $obj->getCode());
    }

}