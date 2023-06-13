<?php

namespace DVSA\CPMS\Queues\Middleware\PipelineBuilders;

use DVSA\CPMS\Queues\Middleware\Interfaces\MiddlewareBuilder;
use DVSA\CPMS\Queues\Middleware\PayloadEditors\Base64DecodePayload;
use DVSA\CPMS\Queues\Middleware\PayloadEditors\Base64EncodePayload;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass DVSA\CPMS\Queues\Middleware\PipelineBuilders\BuildBase64Middleware
 */
class BuildBase64MiddlewareTest extends TestCase
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

        $unit = new BuildBase64Middleware();

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(BuildBase64Middleware::class, $unit);
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

        $unit = new BuildBase64Middleware();

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

        $unit = new BuildBase64Middleware;
        $config = [];

        // ----------------------------------------------------------------
        // perform the change

        $middleware = $unit($config);

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue(is_array($middleware));
        $this->assertArrayHasKey('Encoder', $middleware);
        $this->assertArrayHasKey('Decoder', $middleware);

        $this->assertInstanceOf(Base64EncodePayload::class, $middleware['Encoder']);
        $this->assertInstanceOf(Base64DecodePayload::class, $middleware['Decoder']);
    }
}
