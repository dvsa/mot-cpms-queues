<?php

namespace DVSA\CPMS\Queues\Middleware\Checks;

use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass DVSA\CPMS\Queues\Middleware\Checks\IsValidEncryptionSecret
 */
class IsValidEncryptionSecretTest extends TestCase
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

        $unit = new IsValidEncryptionSecret;

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(IsValidEncryptionSecret::class, $unit);
    }

    /**
     * @covers ::__invoke
     * @dataProvider provideTypesToCheck
     */
    public function testCanUseAsObject($type, $secret, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new IsValidEncryptionSecret;

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = $unit($type, $secret);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::check
     * @dataProvider provideTypesToCheck
     */
    public function testCanCallStatically($type, $secret, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = IsValidEncryptionSecret::check($type, $secret);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    public function provideTypesToCheck()
    {
        return [
            [ 'aes-128-cbc', '1234567890ABCEDF', true ],
            [ 'aes-128-cbc', '', false ],
            [ 'aes-128-cbc', '1234567890', false ],
        ];
    }
}
