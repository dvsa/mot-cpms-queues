<?php

namespace DVSA\CPMS\Queues\Middleware\Checks;

use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass DVSA\CPMS\Queues\Middleware\Checks\IsValidHmacType
 */
class IsValidHmacTypeTest extends TestCase
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

        $unit = new IsValidHmacType;

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(IsValidHmacType::class, $unit);
    }

    /**
     * @covers ::__invoke
     * @dataProvider provideTypesToCheck
     */
    public function testCanUseAsObject($type, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new IsValidHmacType;

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = $unit($type);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::check
     * @dataProvider provideTypesToCheck
     */
    public function testCanCallStatically($type, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = IsValidHmacType::check($type);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    public function provideTypesToCheck()
    {
        return [
            [ 'md5', true ],
            [ 'sha1', true ],
            [ 'sha256', true ],
            [ 'trout', false ],
        ];
    }
}
