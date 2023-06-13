<?php

namespace DVSA\CPMS\Queues\Middleware\PayloadEditors;

use DVSA\CPMS\Queues\Exceptions\E4xx_CannotDecodeMessagePayload;
use DVSA\CPMS\Queues\Middleware\Interfaces\PayloadDecoder;
use DVSA\CPMS\Queues\MultipartMessages\Maps\MapTestMessages;
use DVSA\CPMS\Queues\MultipartMessages\ValueBuilders\BuildPayloadFromTestMessageV1;
use DVSA\CPMS\Queues\MultipartMessages\Values\TestMessageV1;
use DVSA\CPMS\Queues\QueueAdapters\Values\QueueMessage;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass DVSA\CPMS\Queues\Middleware\PayloadEditors\BuildMultipartMessageFromPayload
 */
class BuildMultipartMessageFromPayloadTest extends TestCase
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

        $unit = new BuildMultipartMessageFromPayload($mapper);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(BuildMultipartMessageFromPayload::class, $unit);
    }

    /**
     * @covers ::__construct
     */
    public function testIsPayloadDecoder()
    {
        // ----------------------------------------------------------------
        // setup your test

        $mapper = new MapTestMessages;

        // ----------------------------------------------------------------
        // perform the change

        $unit = new BuildMultipartMessageFromPayload($mapper);

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

        $mapper = new MapTestMessages;
        $unit = new BuildMultipartMessageFromPayload($mapper);

        $expectedPayload = new TestMessageV1("PHPUnit", 1, "Greetings, earthling!");
        $encodedPayload = BuildPayloadFromTestMessageV1::from($expectedPayload);

        $this->assertNotEmpty($encodedPayload);
        $this->assertNotEquals($expectedPayload, $encodedPayload);

        // ----------------------------------------------------------------
        // perform the change

        $actualPayload = $unit($encodedPayload);

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

        $mapper = new MapTestMessages;
        $unit = new BuildMultipartMessageFromPayload($mapper);

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
        $unit = new BuildMultipartMessageFromPayload($mapper);
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
