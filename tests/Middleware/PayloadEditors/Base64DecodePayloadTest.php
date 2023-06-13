<?php

namespace DVSA\CPMS\Queues\Middleware\PayloadEditors;

use DVSA\CPMS\Queues\Exceptions\E4xx_CannotDecodeMessagePayload;
use DVSA\CPMS\Queues\Middleware\Interfaces\PayloadDecoder;
use DVSA\CPMS\Queues\QueueAdapters\Values\QueueMessage;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass DVSA\CPMS\Queues\Middleware\PayloadEditors\Base64DecodePayload
 */
class Base64DecodePayloadTest extends TestCase
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

        $unit = new Base64DecodePayload;

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(Base64DecodePayload::class, $unit);
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

        $unit = new Base64DecodePayload;

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

        $unit = new Base64DecodePayload;

        $expectedPayload = "hello, world!";

        // ----------------------------------------------------------------
        // perform the change

        $actualPayload = $unit(base64_encode($expectedPayload));

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

        $unit = new Base64DecodePayload;

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

        $unit = new Base64DecodePayload;
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
