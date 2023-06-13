<?php

namespace DVSA\CPMS\Queues\Exceptions;

use Exception;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass DVSA\CPMS\Queues\Exceptions\E4xx_MissingConfigSetting
 */
class E4xx_MissingConfigSettingTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanInstantiate()
    {
        // ----------------------------------------------------------------
        // setup your test

        $config = [ 'hello' => 'world' ];
        $key = 'trout';

        // ----------------------------------------------------------------
        // perform the change

        $obj = new E4xx_MissingConfigSetting($config, $key);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(E4xx_MissingConfigSetting::class, $obj);
    }

    /**
     * @covers ::__construct
     */
    public function testIsException()
    {
        // ----------------------------------------------------------------
        // setup your test

        $config = [ 'hello' => 'world' ];
        $key = 'trout';

        // ----------------------------------------------------------------
        // perform the change

        $obj = new E4xx_MissingConfigSetting($config, $key);

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

        $config = [ 'hello' => 'world' ];
        $key = 'trout';
        $expectedCode = 400;

        // ----------------------------------------------------------------
        // perform the change

        $obj = new E4xx_MissingConfigSetting($config, $key);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedCode, $obj->getCode());
    }

}