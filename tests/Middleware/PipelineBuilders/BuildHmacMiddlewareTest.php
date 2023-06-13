<?php

namespace DVSA\CPMS\Queues\Middleware\PipelineBuilders;

use DVSA\CPMS\Queues\Exceptions\E4xx_ConfigMustBeAnArray;
use DVSA\CPMS\Queues\Exceptions\E4xx_MissingConfigSetting;
use DVSA\CPMS\Queues\Middleware\Interfaces\MiddlewareBuilder;
use DVSA\CPMS\Queues\Middleware\PayloadEditors\HmacVerifyPayload;
use DVSA\CPMS\Queues\Middleware\PayloadEditors\HmacSignPayload;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass DVSA\CPMS\Queues\Middleware\PipelineBuilders\BuildHmacMiddleware
 */
class BuildHmacMiddlewareTest extends TestCase
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

        $unit = new BuildHmacMiddleware();

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(BuildHmacMiddleware::class, $unit);
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

        $unit = new BuildHmacMiddleware();

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

        $unit = new BuildHmacMiddleware;
        $config = [
            'type' => "sha256",
            'key'  => "1234567890"
        ];

        // ----------------------------------------------------------------
        // perform the change

        $middleware = $unit($config);

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue(is_array($middleware));
        $this->assertArrayHasKey('Encoder', $middleware);
        $this->assertArrayHasKey('Decoder', $middleware);

        $this->assertInstanceOf(HmacSignPayload::class, $middleware['Encoder']);
        $this->assertInstanceOf(HmacVerifyPayload::class, $middleware['Decoder']);
    }

    /**
     * @covers ::__invoke
     * @covers ::from
     */
    public function testThrowsExceptionIfConfigIsNotAnArray()
    {
        // ----------------------------------------------------------------
        // setup your test

        $this->expectException(E4xx_ConfigMustBeAnArray::class);

        $unit = new BuildHmacMiddleware;
        $config = null;

        // ----------------------------------------------------------------
        // perform the change

        $middleware = $unit($config);
    }

    /**
     * @covers ::__invoke
     * @covers ::from
     */
    public function testThrowsExceptionIfTypeMissingFromConfig()
    {
        // ----------------------------------------------------------------
        // setup your test

        $this->expectException(E4xx_MissingConfigSetting::class);

        $unit = new BuildHmacMiddleware;
        $config = [
            'type' => "sha256",
        ];

        // ----------------------------------------------------------------
        // perform the change

        $middleware = $unit($config);
    }

    /**
     * @covers ::__invoke
     * @covers ::from
     */
    public function testThrowsExceptionIfKeyMissingFromConfig()
    {
        // ----------------------------------------------------------------
        // setup your test

        $this->expectException(E4xx_MissingConfigSetting::class);

        $unit = new BuildHmacMiddleware;
        $config = [
            'key'  => "1234567890"
        ];

        // ----------------------------------------------------------------
        // perform the change

        $middleware = $unit($config);
    }
}
