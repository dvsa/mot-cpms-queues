<?php

namespace DVSA\CPMS\Queues\Exceptions;

use Exception;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass DVSA\CPMS\Queues\Exceptions\E4xx_InvalidEncryptionSecret
 */
class E4xx_InvalidEncryptionSecretTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanInstantiate()
    {
        // ----------------------------------------------------------------
        // setup your test

        $type = "aes-128-cbc";
        $secret = "1234567890";

        // ----------------------------------------------------------------
        // perform the change

        $obj = new E4xx_InvalidEncryptionSecret($type, $secret);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(E4xx_InvalidEncryptionSecret::class, $obj);
    }

    /**
     * @covers ::__construct
     */
    public function testIsException()
    {
        // ----------------------------------------------------------------
        // setup your test

        $type = "aes-128-cbc";
        $secret = "1234567890";

        // ----------------------------------------------------------------
        // perform the change

        $obj = new E4xx_InvalidEncryptionSecret($type, $secret);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(Exception::class, $obj);
    }

    /**
     * @covers ::__construct
     */
    public function testHasErrorCode400()
    {
        // ----------------------------------------------------------------
        // setup your test

        $type = "aes-128-cbc";
        $secret = "1234567890";
        $expectedCode = 400;

        // ----------------------------------------------------------------
        // perform the change

        $obj = new E4xx_InvalidEncryptionSecret($type, $secret);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedCode, $obj->getCode());
    }

}