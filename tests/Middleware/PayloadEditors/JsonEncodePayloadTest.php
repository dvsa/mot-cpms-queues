<?php

namespace DVSA\CPMS\Queues\Middleware\PayloadEditors;

use DVSA\CPMS\Queues\Exceptions\E4xx_CannotEncodeMessagePayload;
use DVSA\CPMS\Queues\Middleware\Interfaces\PayloadEncoder;
use DVSA\CPMS\Queues\QueueAdapters\Values\QueueMessage;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass DVSA\CPMS\Queues\Middleware\PayloadEditors\JsonEncodePayload
 */
class JsonEncodePayloadTest extends TestCase
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

        $unit = new JsonEncodePayload;

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(JsonEncodePayload::class, $unit);
    }

    /**
     * @coversNothing
     */
    public function testIsPayloadEncoder()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $unit = new JsonEncodePayload;

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(PayloadEncoder::class, $unit);
    }

    /**
     * @covers ::__invoke
     */
    public function testWillEncodePayload()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new JsonEncodePayload;

        $payload = [ "hello, world!" ];
        $expectedMessage = json_encode($payload);

        // ----------------------------------------------------------------
        // perform the change

        $actualMessage = $unit($payload);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedMessage, $actualMessage);
    }

    /**
     * @covers ::__invoke
     * @dataProvider provideNonArraysAndObjectsToTest
     */
    public function testThrowsExceptionForNonArrayObjectPayloads($payload)
    {
        // ----------------------------------------------------------------
        // setup your test

        $this->expectException(E4xx_CannotEncodeMessagePayload::class);

        $unit = new JsonEncodePayload;

        // ----------------------------------------------------------------
        // perform the change

        $unit($payload);

        // ----------------------------------------------------------------
        // test the results
    }

    /**
     * @covers ::getMiddlewareName
     */
    public function testCanGetMiddlewareName()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new JsonEncodePayload;
        $expectedName = "Json";

        // ----------------------------------------------------------------
        // perform the change

        $actualName = $unit->getMiddlewareName();

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedName, $actualName);
    }

    public function provideNonArraysAndObjectsToTest()
    {
        return [
            [ null ],
            [ true ],
            [ false ],
            [ 0.0 ],
            [ 3.1415927 ],
            [ 0 ],
            [ 100 ],
            [ STDIN ],
            [ "hello, world!" ],
        ];
    }
}
