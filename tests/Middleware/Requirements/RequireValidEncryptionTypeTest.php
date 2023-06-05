<?php

namespace DVSA\CPMS\Queues\Middleware\Requirements;

use DVSA\CPMS\Queues\Exceptions\E4xx_UnsupportedEncryptionType;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass RequireValidEncryptionType
 */
class RequireValidEncryptionTypeTest extends TestCase
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

        $unit = new RequireValidEncryptionType;

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(RequireValidEncryptionType::class, $unit);
    }

    /**
     * @covers ::__invoke
     * @dataProvider provideTypesToCheck
     */
    public function testCanUseAsObject($type)
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new RequireValidEncryptionType;

        // ----------------------------------------------------------------
        // perform the change

        $unit($type);

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
    public function testCanCallStatically($type)
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        RequireValidEncryptionType::check($type);

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
    public function testThrowsExceptionForInvalidTypes()
    {
        // ----------------------------------------------------------------
        // setup your test

        $this->expectException(E4xx_UnsupportedEncryptionType::class);

        // ----------------------------------------------------------------
        // perform the change

        RequireValidEncryptionType::check('trout');

        // ----------------------------------------------------------------
        // test the results
    }

    public function provideTypesToCheck()
    {
        $retval = [];
        $validTypes = openssl_get_cipher_methods();
        foreach ($validTypes as $validType) {
            $retval[] = [ $validType ];
        }

        return $retval;
    }
}
