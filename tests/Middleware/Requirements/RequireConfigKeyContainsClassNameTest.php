<?php

namespace DVSA\CPMS\Queues\Middleware\Requirements;

use DVSA\CPMS\Queues\Exceptions\E4xx_ConfigKeyMustContainClassName;
use DVSA\CPMS\Queues\Exceptions\E4xx_ConfigKeyMustContainString;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass DVSA\CPMS\Queues\Middleware\Requirements\RequireConfigKeyContainsClassName
 */
class RequireConfigKeyContainsClassNameTest extends TestCase
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

        $unit = new RequireConfigKeyContainsClassName;

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(RequireConfigKeyContainsClassName::class, $unit);
    }

    /**
     * @covers ::__invoke
     */
    public function testCanUseAsObject()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new RequireConfigKeyContainsClassName;

        // ----------------------------------------------------------------
        // perform the change

        $unit(['hello' => 'stdClass'], 'hello');

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

        RequireConfigKeyContainsClassName::check(['hello' => 'stdClass'], 'hello');

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
     * @dataProvider provideNonStringsToTest
     */
    public function testThrowsExceptionWhenConfigSettingContainsNonString($config, $key)
    {
        // ----------------------------------------------------------------
        // setup your test

        $this->expectException(E4xx_ConfigKeyMustContainString::class);

        // ----------------------------------------------------------------
        // perform the change

        RequireConfigKeyContainsClassName::check($config, $key);

        // ----------------------------------------------------------------
        // test the results
    }

    /**
     * @covers ::check
     */
    public function testThrowsExceptionWhenClassCannotBeFound()
    {
        // ----------------------------------------------------------------
        // setup your test

        $this->expectException(E4xx_ConfigKeyMustContainClassName::class);

        // ----------------------------------------------------------------
        // perform the change

        RequireConfigKeyContainsClassName::check(['hello' => 'world'], 'hello');

        // ----------------------------------------------------------------
        // test the results
    }

    public function provideNonStringsToTest()
    {
        return [
            [ [ 'hello' => null ], 'hello' ],
            [ [ 'hello' => [] ], 'hello' ],
            [ [ 'hello' => true ], 'hello' ],
            [ [ 'hello' => false ], 'hello' ],
            [ [ 'hello' => function(){} ], 'hello' ],
            [ [ 'hello' => 0.0 ], 'hello' ],
            [ [ 'hello' => 3.1415927 ], 'hello' ],
            [ [ 'hello' => 0 ], 'hello' ],
            [ [ 'hello' => 100 ], 'hello' ],
            [ [ 'hello' => STDIN ], 'hello' ],
            [ [ 'hello' => (object)[] ], 'hello' ],
        ];
    }
}
