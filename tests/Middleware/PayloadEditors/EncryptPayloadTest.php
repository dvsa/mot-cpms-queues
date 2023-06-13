<?php

namespace DVSA\CPMS\Queues\Middleware\PayloadEditors;

use DVSA\CPMS\Queues\Exceptions\E4xx_CannotEncryptMessagePayload;
use DVSA\CPMS\Queues\Exceptions\E4xx_InvalidEncryptionSecret;
use DVSA\CPMS\Queues\Exceptions\E4xx_UnsupportedEncryptionType;
use DVSA\CPMS\Queues\Middleware\Interfaces\PayloadEncoder;
use DVSA\CPMS\Queues\QueueAdapters\Values\QueueMessage;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass DVSA\CPMS\Queues\Middleware\PayloadEditors\EncryptPayload
 */
class EncryptPayloadTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanInstantiate()
    {
        // ----------------------------------------------------------------
        // setup your test

        $type = "AES-256-CBC";
        $key  = "1234567890";
        $iv   = "0987654321ABCDEF";

        // ----------------------------------------------------------------
        // perform the change

        $unit = new EncryptPayload($type, $key, $iv);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(EncryptPayload::class, $unit);
    }

    /**
     * @covers ::__construct
     */
    public function testIsPayloadEncoder()
    {
        // ----------------------------------------------------------------
        // setup your test

        $type = "AES-256-CBC";
        $key  = "1234567890";
        $iv   = "0987654321ABCDEF";

        // ----------------------------------------------------------------
        // perform the change

        $unit = new EncryptPayload($type, $key, $iv);

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

        $type = "AES-256-CBC";
        $key  = "1234567890";
        $iv   = "0987654321ABCDEF";

        $unit = new EncryptPayload($type, $key, $iv);

        $payload = "hello, world!";
        $expectedMessage = openssl_encrypt($payload, $type, $key, OPENSSL_RAW_DATA, $iv);

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
    public function testThrowsExceptionForUnsupportedEncryptionType()
    {
        // ----------------------------------------------------------------
        // setup your test

        $this->expectException(E4xx_UnsupportedEncryptionType::class);

        // ----------------------------------------------------------------
        // perform the change

        $unit = new EncryptPayload('trout', '1234567890', '0987654321ABCDEF');

        // ----------------------------------------------------------------
        // test the results
    }

    /**
     * @covers ::__construct
     */
    public function testThrowsExceptionForInvalidEncryptionSecret()
    {
        // ----------------------------------------------------------------
        // setup your test

        $this->expectException(E4xx_InvalidEncryptionSecret::class);

        // ----------------------------------------------------------------
        // perform the change

        $unit = new EncryptPayload('AES-256-CBC', '1234567890', '0987654321');

        // ----------------------------------------------------------------
        // test the results
    }

    /**
     * @covers ::__invoke
     * @dataProvider provideNonStringsToTest
     */
    public function testThrowsExceptionForNonStringPayloads($payload)
    {
        // ----------------------------------------------------------------
        // setup your test

        $this->expectException(E4xx_CannotEncryptMessagePayload::class);

        $unit = new EncryptPayload('AES-256-CBC', '1234567890', '0987654321ABCDEF');

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

        $unit = new EncryptPayload('AES-256-CBC', '1234567890', '0987654321ABCDEF');
        $expectedName = "Encryption";

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
