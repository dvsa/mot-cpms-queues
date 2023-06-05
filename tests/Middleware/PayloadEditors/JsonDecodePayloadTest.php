<?php

namespace DVSA\CPMS\Queues\Middleware\PayloadEditors;

use DVSA\CPMS\Queues\Exceptions\E4xx_CannotDecodeMessagePayload;
use DVSA\CPMS\Queues\Middleware\Interfaces\PayloadDecoder;
use DVSA\CPMS\Queues\QueueAdapters\Values\QueueMessage;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass DVSA\CPMS\Queues\Middleware\PayloadEditors\JsonDecodePayload
 */
class JsonDecodePayloadTest extends TestCase
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

        $unit = new JsonDecodePayload;

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(JsonDecodePayload::class, $unit);
    }

    /**
     * @coversNothing
     */
    public function testIsPayloadDecoder()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $unit = new JsonDecodePayload;

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(PayloadDecoder::class, $unit);
    }

    /**
     * @covers ::__invoke
     */
    public function testWillDecodePayload()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new JsonDecodePayload;

        $expectedPayload = (object)[ "fred" => "hello, world!" ];

        // ----------------------------------------------------------------
        // perform the change

        $actualPayload = $unit(json_encode($expectedPayload));

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedPayload, $actualPayload);
    }

    /**
     * @covers ::__invoke
     * @dataProvider provideNonStringsToTest
     */
    public function testThrowsExceptionForNonStringPayloads($payload)
    {
        // ----------------------------------------------------------------
        // setup your test

        $this->expectException(E4xx_CannotDecodeMessagePayload::class);

        $unit = new JsonDecodePayload;

        // ----------------------------------------------------------------
        // perform the change

        $unit($payload);

        // ----------------------------------------------------------------
        // test the results
    }

    /**
     * @covers ::__invoke
     */
    public function testThrowsExceptionForNonJsonPayloads()
    {
        // ----------------------------------------------------------------
        // setup your test

        $this->expectException(E4xx_CannotDecodeMessagePayload::class);

        $unit = new JsonDecodePayload;

        // this is not valid JSON, because it uses single quotes for keys
        // and values instead of double quotes
        $payload = "'fred': 'hello, world'";

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

        $unit = new JsonDecodePayload;
        $expectedName = "Json";

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