<?php

namespace DVSA\CPMS\Queues\Middleware\PayloadEditors;

use DVSA\CPMS\Queues\Exceptions\E4xx_CannotEncodeMessagePayload;
use DVSA\CPMS\Queues\Middleware\Interfaces\PayloadENcoder;
use DVSA\CPMS\Queues\MultipartMessages\Maps\MapTestMessages;
use DVSA\CPMS\Queues\MultipartMessages\ValueBuilders\BuildPayloadFromTestMessageV1;
use DVSA\CPMS\Queues\MultipartMessages\Values\TestMessageV1;
use DVSA\CPMS\Queues\QueueAdapters\Values\QueueMessage;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass DVSA\CPMS\Queues\Middleware\PayloadEditors\BuildPayloadFromMultipartMessage
 */
class BuildPayloadFromMultipartMessageTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanInstantiate()
    {
        // ----------------------------------------------------------------
        // setup your test

        $mapper = new MapTestMessages;

        // ----------------------------------------------------------------
        // perform the change

        $unit = new BuildPayloadFromMultipartMessage($mapper);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(BuildPayloadFromMultipartMessage::class, $unit);
    }

    /**
     * @covers ::__construct
     */
    public function testIsPayloadEncoder()
    {
        // ----------------------------------------------------------------
        // setup your test

        $mapper = new MapTestMessages;

        // ----------------------------------------------------------------
        // perform the change

        $unit = new BuildPayloadFromMultipartMessage($mapper);

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

        $mapper = new MapTestMessages;
        $unit = new BuildPayloadFromMultipartMessage($mapper);

        $payload = new TestMessageV1("PHPUnit", 1, "Greetings, earthling!");
        $expectedPayload = BuildPayloadFromTestMessageV1::from($payload);

        $this->assertNotEmpty($payload);
        $this->assertNotEquals($expectedPayload, $payload);

        // ----------------------------------------------------------------
        // perform the change

        $actualPayload = $unit($payload);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedPayload, $actualPayload);
    }

    /**
     * @covers ::__invoke
     * @dataProvider provideNonStringsToTest
     */
    public function testThrowsExceptionForNonObjectPayloads($payload)
    {
        // ----------------------------------------------------------------
        // setup your test

        $this->expectException(E4xx_CannotEncodeMessagePayload::class);

        $mapper = new MapTestMessages;
        $unit = new BuildPayloadFromMultipartMessage($mapper);

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

        $mapper = new MapTestMessages;
        $unit = new BuildPayloadFromMultipartMessage($mapper);
        $expectedName = "MultipartMessage";

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
            [ 0.0 ],
            [ 3.1415927 ],
            [ 0 ],
            [ 100 ],
            [ STDIN ],
        ];
    }

}
