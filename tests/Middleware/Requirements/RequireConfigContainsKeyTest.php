<?php

namespace DVSA\CPMS\Queues\Middleware\Requirements;

use DVSA\CPMS\Queues\Exceptions\E4xx_MissingConfigSetting;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass DVSA\CPMS\Queues\Middleware\Requirements\RequireConfigContainsKey
 */
class RequireConfigContainsKeyTest extends TestCase
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

        $unit = new RequireConfigContainsKey;

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(RequireConfigContainsKey::class, $unit);
    }

    /**
     * @covers ::__invoke
     */
    public function testCanUseAsObject()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new RequireConfigContainsKey;

        // ----------------------------------------------------------------
        // perform the change

        $unit(['hello' => 'world'], 'hello');

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

        RequireConfigContainsKey::check(['hello' => 'world'], 'hello');

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
    public function testThrowsExceptionForMissingConfigSetting()
    {
        // ----------------------------------------------------------------
        // setup your test

        $this->expectException(E4xx_MissingConfigSetting::class);

        // ----------------------------------------------------------------
        // perform the change

        RequireConfigContainsKey::check([], 'hello');

        // ----------------------------------------------------------------
        // test the results
    }
}
