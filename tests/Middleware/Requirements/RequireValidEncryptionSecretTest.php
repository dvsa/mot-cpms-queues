<?php

namespace DVSA\CPMS\Queues\Middleware\Requirements;

use DVSA\CPMS\Queues\Exceptions\E4xx_InvalidEncryptionSecret;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass DVSA\CPMS\Queues\Middleware\Requirements\RequireValidEncryptionSecret
 */
class RequireValidEncryptionSecretTest extends TestCase
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

        $unit = new RequireValidEncryptionSecret;

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(RequireValidEncryptionSecret::class, $unit);
    }

    /**
     * @covers ::__invoke
     * @dataProvider provideTypesToCheck
     */
    public function testCanUseAsObject($type, $secret)
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new RequireValidEncryptionSecret;

        // ----------------------------------------------------------------
        // perform the change

        $unit($type, $secret);

        // ----------------------------------------------------------------
        // test the results
        //
        // if we get here without an exception, all is well
        //
        // we need to assert *something* to avoid this test being marked
        // as a useless test

        $this->assertTrue(true);
    }

    /**
     * @covers ::check
     * @dataProvider provideTypesToCheck
     */
    public function testCanCallStatically($type, $secret)
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        RequireValidEncryptionSecret::check($type, $secret);

        // ----------------------------------------------------------------
        // test the results

        // if we get here without an exception, all is well
        //
        // we need to assert *something* to avoid this test being marked
        // as a useless test

        $this->assertTrue(true);
    }

    /**
     * @covers ::check
     */
    public function testThrowsExceptionForInvalidSecrets()
    {
        // ----------------------------------------------------------------
        // setup your test

        $this->expectException(E4xx_InvalidEncryptionSecret::class);

        // ----------------------------------------------------------------
        // perform the change

        RequireValidEncryptionSecret::check('aes-128-cbc', '');

        // ----------------------------------------------------------------
        // test the results
    }

    public function provideTypesToCheck()
    {
        return [
            [ 'aes-128-cbc', '1234567890ABCEDF' ],
        ];
    }
}
