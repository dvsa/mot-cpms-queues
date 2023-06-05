<?php

namespace DVSA\CPMS\Queues\Middleware\PipelineBuilders;

use DVSA\CPMS\Queues\Exceptions\E4xx_InvalidMiddlewareBuilder;
use DVSA\CPMS\Queues\Exceptions\E4xx_NoSuchMiddleware;
use DVSA\CPMS\Queues\Middleware\Interfaces\MiddlewareBuilder;
use DVSA\CPMS\Queues\Middleware\PayloadEditors\Base64DecodePayload;
use DVSA\CPMS\Queues\Middleware\PayloadEditors\Base64EncodePayload;
use DVSA\CPMS\Queues\Middleware\PayloadEditors\DecryptPayload;
use DVSA\CPMS\Queues\Middleware\PayloadEditors\EncryptPayload;
use DVSA\CPMS\Queues\Middleware\PayloadEditors\HmacVerifyPayload;
use DVSA\CPMS\Queues\Middleware\PayloadEditors\HmacSignPayload;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass DVSA\CPMS\Queues\Middleware\PipelineBuilders\BuildMiddlewarePipelines
 */
class BuildMiddlewarePipelinesTest extends TestCase
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

        $unit = new BuildMiddlewarePipelines();

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(BuildMiddlewarePipelines::class, $unit);
    }

    /**
     * @covers ::__invoke
     * @covers ::from
     */
    public function testWillBuildPipelines()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new BuildMiddlewarePipelines;
        $config = [
            'Encryption' => [
                'type'   => "AES-256-CBC",
                'key'    => "1234567890",
                'secret' => "0987654321ABCDEF",
            ],
            'Base64' => [],
            'Hmac' => [
                'type' => "sha256",
                'key'  => "1234567890"
            ]
        ];

        // ----------------------------------------------------------------
        // perform the change

        $middleware = $unit($config);

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue(is_array($middleware));
        $this->assertArrayHasKey('Encoders', $middleware);
        $this->assertArrayHasKey('Decoders', $middleware);
        $this->assertNotEmpty($middleware['Encoders']);
        $this->assertNotEmpty($middleware['Decoders']);
    }

    /**
     * @covers ::__invoke
     * @covers ::from
     */
    public function testWillBuildPipelinesInMirroredOrder()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new BuildMiddlewarePipelines;
        $config = [
            'Encryption' => [
                'type'   => "AES-256-CBC",
                'key'    => "1234567890",
                'secret' => "0987654321ABCDEF",
            ],
            'Base64' => [],
            'Hmac' => [
                'type' => "sha256",
                'key'  => "1234567890"
            ]
        ];

        // ----------------------------------------------------------------
        // perform the change

        $middleware = $unit($config);

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue(is_array($middleware));
        $this->assertArrayHasKey('Encoders', $middleware);
        $this->assertArrayHasKey('Decoders', $middleware);

        // the encoding pipeline should be in the same order as the config
        // used to build the pipelines
        $this->assertInstanceOf(EncryptPayload::class, $middleware['Encoders'][0]);
        $this->assertInstanceOf(Base64EncodePayload::class, $middleware['Encoders'][1]);
        $this->assertInstanceOf(HmacSignPayload::class, $middleware['Encoders'][2]);

        // the decoding pipeline should be in the reverse order
        $this->assertInstanceOf(HmacVerifyPayload::class, $middleware['Decoders'][0]);
        $this->assertInstanceOf(Base64DecodePayload::class, $middleware['Decoders'][1]);
        $this->assertInstanceOf(DecryptPayload::class, $middleware['Decoders'][2]);
    }

    /**
     * @covers ::__invoke
     * @covers ::from
     */
    public function testWillBuildPipelinesUsingExplicitClassnames()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new BuildMiddlewarePipelines;
        $config = [
            BuildEncryptionMiddleware::class => [
                'type'   => "AES-256-CBC",
                'key'    => "1234567890",
                'secret' => "0987654321ABCDEF",
            ],
            BuildBase64Middleware::class => [],
            BuildHmacMiddleware::class => [
                'type' => "sha256",
                'key'  => "1234567890"
            ]
        ];

        // ----------------------------------------------------------------
        // perform the change

        $middleware = $unit($config);

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue(is_array($middleware));
        $this->assertArrayHasKey('Encoders', $middleware);
        $this->assertArrayHasKey('Decoders', $middleware);

        // make sure our encoding pipeline was built
        $this->assertInstanceOf(EncryptPayload::class, $middleware['Encoders'][0]);
        $this->assertInstanceOf(Base64EncodePayload::class, $middleware['Encoders'][1]);
        $this->assertInstanceOf(HmacSignPayload::class, $middleware['Encoders'][2]);

        // make sure our decoding pipeline was built
        $this->assertInstanceOf(HmacVerifyPayload::class, $middleware['Decoders'][0]);
        $this->assertInstanceOf(Base64DecodePayload::class, $middleware['Decoders'][1]);
        $this->assertInstanceOf(DecryptPayload::class, $middleware['Decoders'][2]);
    }

    /**
     * @covers ::__invoke
     * @covers ::from
     */
    public function testThrowsExceptionWhenUnknownMiddlewareListedInConfig()
    {
        // ----------------------------------------------------------------
        // setup your test

        $this->expectException(E4xx_NoSuchMiddleware::class);

        $unit = new BuildMiddlewarePipelines;
        $config = [
            'Trout' => [],
        ];

        // ----------------------------------------------------------------
        // perform the change

        $middleware = $unit($config);

        // ----------------------------------------------------------------
        // test the results
    }

    /**
     * @covers ::__invoke
     * @covers ::from
     */
    public function testThrowsExceptionWhenInvalidMiddlewareListedInConfig()
    {
        // ----------------------------------------------------------------
        // setup your test

        $this->expectException(E4xx_InvalidMiddlewareBuilder::class);

        $unit = new BuildMiddlewarePipelines;
        $config = [
            BuildMiddlewarePipelinesTest_InvalidMiddleware::class => [],
        ];

        // ----------------------------------------------------------------
        // perform the change

        $middleware = $unit($config);

        // ----------------------------------------------------------------
        // test the results
    }

}

class BuildMiddlewarePipelinesTest_InvalidMiddleware
{

}