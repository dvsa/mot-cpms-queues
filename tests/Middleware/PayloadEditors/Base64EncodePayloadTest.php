<?php

namespace DVSA\CPMS\Queues\Middleware\PayloadEditors;

use DVSA\CPMS\Queues\Exceptions\E4xx_CannotEncodeMessagePayload;
use DVSA\CPMS\Queues\Middleware\Interfaces\PayloadEncoder;
use DVSA\CPMS\Queues\QueueAdapters\Values\QueueMessage;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass DVSA\CPMS\Queues\Middleware\PayloadEditors\Base64EncodePayload
 */
class Base64EncodePayloadTest extends TestCase
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

        $unit = new Base64EncodePayload;

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(Base64EncodePayload::class, $unit);
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

        $unit = new Base64EncodePayload;

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

        $unit = new Base64EncodePayload;

        $payload = "hello, world!";
        $expectedMessage = base64_encode($payload);

        // ----------------------------------------------------------------
        // perform the change

        $actualMessage = $unit($payload);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedMessage, $actualMessage);
    }

    /**
     * @covers ::__invoke
     * @dataProvider provideNonStringsToTest
     */
    public function testThrowsExceptionForNonStringPayloads($payload)
    {
        // ----------------------------------------------------------------
        // setup your test

        $this->expectException(E4xx_CannotEncodeMessagePayload::class);

        $unit = new Base64EncodePayload;

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

        $unit = new Base64EncodePayload;
        $expectedName = "Base64";

        // ----------------------------------------------------------------
        // perform the change

        $actualName = $unit->getMiddlewareName();

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedName, $actualName);
    }

    public function provideNonStringsToTest()
    {
        return [
            [ null ],
            [ [] ],
            [ true ],
            [ false ],
            [ function() {} ],
            [ 0.0 ],
            [ 3.1415927 ],
            [ 0 ],
            [ 100 ],
            [ (object)[] ],
            [ STDIN ],
        ];
    }
}
