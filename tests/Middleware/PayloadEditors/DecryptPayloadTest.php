<?php

namespace DVSA\CPMS\Queues\Middleware\PayloadEditors;

use DVSA\CPMS\Queues\Exceptions\E4xx_CannotDecryptMessagePayload;
use DVSA\CPMS\Queues\Exceptions\E4xx_InvalidEncryptionSecret;
use DVSA\CPMS\Queues\Exceptions\E4xx_UnsupportedEncryptionType;
use DVSA\CPMS\Queues\Middleware\Interfaces\PayloadDecoder;
use DVSA\CPMS\Queues\QueueAdapters\Values\QueueMessage;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass DVSA\CPMS\Queues\Middleware\PayloadEditors\DecryptPayload
 */
class DecryptPayloadTest extends TestCase
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

        $unit = new DecryptPayload($type, $key, $iv);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(DecryptPayload::class, $unit);
    }

    /**
     * @covers ::__construct
     */
    public function testIsPayloadDecoder()
    {
        // ----------------------------------------------------------------
        // setup your test

        $type = "AES-256-CBC";
        $key  = "1234567890";
        $iv   = "0987654321ABCDEF";

        // ----------------------------------------------------------------
        // perform the change

        $unit = new DecryptPayload($type, $key, $iv);

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

        $type = "AES-256-CBC";
        $key  = "1234567890";
        $iv   = "0987654321ABCDEF";

        $unit = new DecryptPayload($type, $key, $iv);

        $expectedPayload = "hello, world!";
        $encryptedPayload = openssl_encrypt($expectedPayload, $type, $key, OPENSSL_RAW_DATA, $iv);
        $this->assertNotEmpty($encryptedPayload);
        $this->assertNotSame($expectedPayload, $encryptedPayload);

        // ----------------------------------------------------------------
        // perform the change

        $actualPayload = $unit($encryptedPayload);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedPayload, $actualPayload);
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

        $unit = new DecryptPayload('trout', '1234567890', '0987654321ABCDEF');

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

        $unit = new DecryptPayload('AES-256-CBC', '1234567890', '0987654321');

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

        $this->expectException(E4xx_CannotDecryptMessagePayload::class);

        $unit = new DecryptPayload('AES-256-CBC', '1234567890', '0987654321ABCDEF');

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

        $unit = new DecryptPayload('AES-256-CBC', '1234567890', '0987654321ABCDEF');
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
