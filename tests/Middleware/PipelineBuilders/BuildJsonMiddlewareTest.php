<?php

namespace DVSA\CPMS\Queues\Middleware\PipelineBuilders;

use DVSA\CPMS\Queues\Middleware\Interfaces\MiddlewareBuilder;
use DVSA\CPMS\Queues\Middleware\PayloadEditors\JsonDecodePayload;
use DVSA\CPMS\Queues\Middleware\PayloadEditors\JsonEncodePayload;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass DVSA\CPMS\Queues\Middleware\PipelineBuilders\BuildJsonMiddleware
 */
class BuildJsonMiddlewareTest extends TestCase
{
    /**
     * @coversNothing
     */
    public function testCanInstantiate()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $unit = new BuildJsonMiddleware();

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(BuildJsonMiddleware::class, $unit);
    }

    /**
     * @coversNothing
     */
    public function testIsMiddlewareBuilder()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $unit = new BuildJsonMiddleware();

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(MiddlewareBuilder::class, $unit);
    }

    /**
     * @covers ::__invoke
     * @covers ::from
     */
    public function testWillBuildMiddleware()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new BuildJsonMiddleware;
        $config = [];

        // ----------------------------------------------------------------
        // perform the change

        $middleware = $unit($config);

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue(is_array($middleware));
        $this->assertArrayHasKey('Encoder', $middleware);
        $this->assertArrayHasKey('Decoder', $middleware);

        $this->assertInstanceOf(JsonEncodePayload::class, $middleware['Encoder']);
        $this->assertInstanceOf(JsonDecodePayload::class, $middleware['Decoder']);
    }
}
