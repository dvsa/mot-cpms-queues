<?php

namespace DVSA\CPMS\Queues\Middleware\PayloadEditors;

use DVSA\CPMS\Queues\Exceptions\E4xx_UnsupportedHmacType;
use DVSA\CPMS\Queues\Middleware\Interfaces\PayloadEncoder;
use DVSA\CPMS\Queues\QueueAdapters\Values\QueueMessage;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass DVSA\CPMS\Queues\Middleware\PayloadEditors\HmacSignPayload
 */
class HmacSignPayloadTest extends TestCase
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

        $unit = new HmacSignPayload($type, $key);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(HmacSignPayload::class, $unit);
    }

    /**
     * @covers ::__construct
     */
    public function testIsPayloadEncoder()
    {
        // ----------------------------------------------------------------
        // setup your test

        $type = "sha256";
        $key  = "1234567890";

        // ----------------------------------------------------------------
        // perform the change

        $unit = new HmacSignPayload($type, $key);

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

        $type = "sha256";
        $key  = "1234567890";

        $unit = new HmacSignPayload($type, $key);

        $payload = "hello, world!";
        $expectedMessage = hash_hmac($type, $payload, $key) . '::' . $payload;

        // a couple of checks to make sure that our expected message
        // isn't junk
        $this->assertNotEmpty($expectedMessage);
        $this->assertNotEquals($expectedMessage, $payload);

        // ----------------------------------------------------------------
        // perform the change

        $actualMessage = $unit($payload);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedMessage, $actualMessage);
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

        $unit = new HmacSignPayload('trout', '1234567890');

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

        $unit = new HmacSignPayload($type, $key);

        $expectedName = "Hmac";

        // ----------------------------------------------------------------
        // perform the change

        $actualName = $unit->getMiddlewareName();

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedName, $actualName);
    }

}
