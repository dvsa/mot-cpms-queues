<?php

namespace DVSA\CPMS\Queues\Middleware\Checks;

use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass DVSA\CPMS\Queues\Middleware\Checks\IsValidEncryptionType
 */
class IsValidEncryptionTypeTest extends TestCase
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

        $unit = new IsValidEncryptionType;

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(IsValidEncryptionType::class, $unit);
    }

    /**
     * @covers ::__invoke
     * @dataProvider provideTypesToCheck
     */
    public function testCanUseAsObject($type, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new IsValidEncryptionType;

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

        $actualResult = IsValidEncryptionType::check($type);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    public function provideTypesToCheck()
    {
        return [
            [ 'aes-128-cbc', true ],
            [ 'des-cbc', true ],
            [ 'sha256', false ],
            [ 'trout', false ],
        ];
    }
}
