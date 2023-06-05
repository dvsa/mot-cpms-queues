<?php

namespace DVSA\CPMS\Queues\Middleware\PipelineBuilders;

use DVSA\CPMS\Queues\Exceptions\E4xx_ConfigMustBeAnArray;
use DVSA\CPMS\Queues\Exceptions\E4xx_MissingConfigSetting;
use DVSA\CPMS\Queues\Middleware\Interfaces\MiddlewareBuilder;
use DVSA\CPMS\Queues\Middleware\PayloadEditors\DecryptPayload;
use DVSA\CPMS\Queues\Middleware\PayloadEditors\EncryptPayload;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass DVSA\CPMS\Queues\Middleware\PipelineBuilders\BuildEncryptionMiddleware
 */
class BuildEncryptionMiddlewareTest extends TestCase
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

        $unit = new BuildEncryptionMiddleware();

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(BuildEncryptionMiddleware::class, $unit);
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

        $unit = new BuildEncryptionMiddleware();

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

        $unit = new BuildEncryptionMiddleware;
        $config = [
            'type'   => "AES-256-CBC",
            'key'    => "1234567890",
            'secret' => "0987654321ABCDEF",
        ];

        // ----------------------------------------------------------------
        // perform the change

        $middleware = $unit($config);

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue(is_array($middleware));
        $this->assertArrayHasKey('Encoder', $middleware);
        $this->assertArrayHasKey('Decoder', $middleware);

        $this->assertInstanceOf(EncryptPayload::class, $middleware['Encoder']);
        $this->assertInstanceOf(DecryptPayload::class, $middleware['Decoder']);
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

        $unit = new BuildEncryptionMiddleware;
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

        $unit = new BuildEncryptionMiddleware;
        $config = [
            'key'    => "1234567890",
            'secret' => "0987654321ABCDEF",
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

        $unit = new BuildEncryptionMiddleware;
        $config = [
            'type'   => "AES-256-CBC",
            'secret' => "0987654321ABCDEF",
        ];

        // ----------------------------------------------------------------
        // perform the change

        $middleware = $unit($config);
    }

    /**
     * @covers ::__invoke
     * @covers ::from
     */
    public function testThrowsExceptionIfSecretMissingFromConfig()
    {
        // ----------------------------------------------------------------
        // setup your test

        $this->expectException(E4xx_MissingConfigSetting::class);

        $unit = new BuildEncryptionMiddleware;
        $config = [
            'type'   => "AES-256-CBC",
            'key'    => "1234567890",
        ];

        // ----------------------------------------------------------------
        // perform the change

        $middleware = $unit($config);
    }

}
