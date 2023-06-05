<?php

namespace DVSA\CPMS\Queues\Middleware\Requirements;

use DVSA\CPMS\Queues\Exceptions\E4xx_ConfigMustBeAnArray;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass DVSA\CPMS\Queues\Middleware\Requirements\RequireConfigAsArray
 */
class RequireConfigAsArrayTest extends TestCase
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

        $unit = new RequireConfigAsArray;

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(RequireConfigAsArray::class, $unit);
    }

    /**
     * @covers ::__invoke
     */
    public function testCanUseAsObject()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new RequireConfigAsArray;

        // ----------------------------------------------------------------
        // perform the change

        $unit([]);

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
     */
    public function testCanCallStatically()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        RequireConfigAsArray::check([]);

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
     * @dataProvider provideInvalidConfigs
     */
    public function testThrowsExceptionForInvalidConfigs($invalidConfig)
    {
        // ----------------------------------------------------------------
        // setup your test

        $this->expectException(E4xx_ConfigMustBeAnArray::class);

        // ----------------------------------------------------------------
        // perform the change

        RequireConfigAsArray::check($invalidConfig);

        // ----------------------------------------------------------------
        // test the results
    }

    public function provideInvalidConfigs()
    {
        return [
            [ null ],
            [ true ],
            [ false ],
            [ function() {} ],
            [ 0.0 ],
            [ 3.1415927 ],
            [ 0 ],
            [ 100 ],
            [ STDIN ],
            [ (object)[] ],
            [ "hello, world" ],
        ];
    }
}
