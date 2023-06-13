<?php

namespace DVSA\CPMS\Queues\Middleware\PipelineBuilders;

use DVSA\CPMS\Queues\Exceptions\E4xx_ConfigKeyMustContainClassNameOfType;
use DVSA\CPMS\Queues\Exceptions\E4xx_ConfigMustBeAnArray;
use DVSA\CPMS\Queues\Exceptions\E4xx_MissingConfigSetting;
use DVSA\CPMS\Queues\Middleware\Interfaces\MiddlewareBuilder;
use DVSA\CPMS\Queues\Middleware\PayloadEditors\BuildMultipartMessageFromPayload;
use DVSA\CPMS\Queues\Middleware\PayloadEditors\BuildPayloadFromMultipartMessage;
use DVSA\CPMS\Queues\MultipartMessages\Maps\MapTestMessages;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass DVSA\CPMS\Queues\Middleware\PipelineBuilders\BuildMultipartMessageMiddleware
 */
class BuildMultipartMessageMiddlewareTest extends TestCase
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

        $unit = new BuildMultipartMessageMiddleware();

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(BuildMultipartMessageMiddleware::class, $unit);
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

        $unit = new BuildMultipartMessageMiddleware();

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

        $unit = new BuildMultipartMessageMiddleware;
        $config = [
            'mapper' => MapTestMessages::class,
        ];

        // ----------------------------------------------------------------
        // perform the change

        $middleware = $unit($config);

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue(is_array($middleware));
        $this->assertArrayHasKey('Encoder', $middleware);
        $this->assertArrayHasKey('Decoder', $middleware);

        $this->assertInstanceOf(BuildPayloadFromMultipartMessage::class, $middleware['Encoder']);
        $this->assertInstanceOf(BuildMultipartMessageFromPayload::class, $middleware['Decoder']);
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

        $unit = new BuildMultipartMessageMiddleware;
        $config = null;

        // ----------------------------------------------------------------
        // perform the change

        $middleware = $unit($config);
    }

    /**
     * @covers ::__invoke
     * @covers ::from
     */
    public function testThrowsExceptionIfMapperMissingFromConfig()
    {
        // ----------------------------------------------------------------
        // setup your test

        $this->expectException(E4xx_MissingConfigSetting::class);

        $unit = new BuildMultipartMessageMiddleware;
        $config = [
        ];

        // ----------------------------------------------------------------
        // perform the change

        $middleware = $unit($config);
    }

    /**
     * @covers ::__invoke
     * @covers ::from
     */
    public function testThrowsExceptionIfInvalidMapperListedInConfig()
    {
        // ----------------------------------------------------------------
        // setup your test

        $this->expectException(E4xx_ConfigKeyMustContainClassNameOfType::class);

        $unit = new BuildMultipartMessageMiddleware;
        $config = [
            'mapper' => \stdClass::class,
        ];

        // ----------------------------------------------------------------
        // perform the change

        $middleware = $unit($config);
    }
}
