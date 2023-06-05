<?php

namespace DVSA\CPMS\Queues\Middleware\PayloadEditors;

use DVSA\CPMS\Queues\Exceptions\E4xx_UnsignedMessage;
use DVSA\CPMS\Queues\Exceptions\E4xx_UnsupportedHmacType;
use DVSA\CPMS\Queues\Exceptions\E4xx_UnverifiedMessage;
use DVSA\CPMS\Queues\Middleware\Interfaces\PayloadDecoder;
use DVSA\CPMS\Queues\QueueAdapters\Values\QueueMessage;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass DVSA\CPMS\Queues\Middleware\PayloadEditors\HmacVerifyPayload
 */
class HmacVerifyPayloadTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanInstantiate()
    {
        // ----------------------------------------------------------------
        // setup your test

        $type = "sha256";
        $key  = "1234567890";

        // ----------------------------------------------------------------
        // perform the change

        $unit = new HmacVerifyPayload($type, $key);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(HmacVerifyPayload::class, $unit);
    }

    /**
     * @covers ::__construct
     */
    public function testIsPayloadDecoder()
    {
        // ----------------------------------------------------------------
        // setup your test

        $type = "sha256";
        $key  = "1234567890";

        // ----------------------------------------------------------------
        // perform the change

        $unit = new HmacVerifyPayload($type, $key);

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

        $type = "sha256";
        $key  = "1234567890";

        $unit = new HmacVerifyPayload($type, $key);
        $encoder = new HmacSignPayload($type, $key);

        $expectedPayload = "hello, world!";
        $signedPayload = $encoder($expectedPayload);
        $this->assertNotEquals($expectedPayload, $signedPayload);

        // ----------------------------------------------------------------
        // perform the change

        $actualPayload = $unit($signedPayload);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedPayload, $actualPayload);
    }

    /**
     * @covers ::__construct
     */
    public function testThrowsExceptionForUnsupportedHmacType()
    {
        // ----------------------------------------------------------------
        // setup your test

        $this->expectException(E4xx_UnsupportedHmacType::class);

        // ----------------------------------------------------------------
        // perform the change

        $unit = new HmacVerifyPayload('trout', '1234567890');

        // ----------------------------------------------------------------
        // test the results
    }

    /**
     * @covers ::__invoke
     */
    public function testThrowsExceptionForUnsignedMessage()
    {
        // ----------------------------------------------------------------
        // setup your test

        $this->expectException(E4xx_UnsignedMessage::class);

        $type = "sha256";
        $key  = "1234567890";

        $unit = new HmacVerifyPayload($type, $key);
        $payload = "hello, world!";

        // ----------------------------------------------------------------
        // perform the change

        $unit($payload);
    }

    /**
     * @covers ::__invoke
     */
    public function testThrowsExceptionForMissignedMessage()
    {
        // ----------------------------------------------------------------
        // setup your test

        $this->expectException(E4xx_UnverifiedMessage::class);

        $type = "sha256";
        $key  = "1234567890";

        $unit = new HmacVerifyPayload($type, $key);
        $encoder = new HmacSignPayload('sha512', $key);

        $payload = $encoder("hello, world");

        // ----------------------------------------------------------------
        // perform the change

        $decodedPayload = $unit($payload);

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

        $type = "sha256";
        $key  = "1234567890";

        $unit = new HmacVerifyPayload($type, $key);

        $expectedName = "Hmac";

        // ----------------------------------------------------------------
        // perform the change

        $actualName = $unit->getMiddlewareName();

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedName, $actualName);
    }
}
