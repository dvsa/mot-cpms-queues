<?php

namespace DVSA\CPMS\Queues\Middleware\Requirements;

use DVSA\CPMS\Queues\Exceptions\E4xx_UnsupportedHmacType;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass DVSA\CPMS\Queues\Middleware\Requirements\RequireValidHmacType
 */
class RequireValidHmacTypeTest extends TestCase
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

        $unit = new RequireValidHmacType;

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(RequireValidHmacType::class, $unit);
    }

    /**
     * @covers ::__invoke
     * @dataProvider provideTypesToCheck
     */
    public function testCanUseAsObject($type)
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new RequireValidHmacType;

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

        RequireValidHmacType::check($type);

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

        $this->expectException(E4xx_UnsupportedHmacType::class);

        // ----------------------------------------------------------------
        // perform the change

        RequireValidHmacType::check('trout');

        // ----------------------------------------------------------------
        // test the results
    }

    public function provideTypesToCheck()
    {
        $retval = [];
        $validTypes = hash_algos();
        foreach ($validTypes as $validType) {
            $retval[] = [ $validType ];
        }

        return $retval;
    }
}
