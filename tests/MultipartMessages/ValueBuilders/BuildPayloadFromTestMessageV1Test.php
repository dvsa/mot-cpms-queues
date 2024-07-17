<?php

namespace DVSA\CPMS\Queues\MultipartMessages\ValueBuilders;

use DVSA\CPMS\Queues\MultipartMessages\Values\TestMessageV1;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass DVSA\CPMS\Queues\MultipartMessages\ValueBuilders\BuildPayloadFromTestMessageV1
 */
class BuildPayloadFromTestMessageV1Test extends TestCase
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

        $unit = new BuildPayloadFromTestMessageV1;

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(BuildPayloadFromTestMessageV1::class, $unit);
    }

    /**
     * @covers ::__invoke
     * @covers ::from
     * @dataProvider provideMessagesToDecode
     */
    public function testCanUseAsObject($rawMessage, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new BuildPayloadFromTestMessageV1;

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = $unit($rawMessage);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::from
     * @dataProvider provideMessagesToDecode
     */
    public function testCanCallStatically($rawMessage, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = BuildPayloadFromTestMessageV1::from($rawMessage);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    public function provideMessagesToDecode()
    {
        return [
            [
                new TestMessageV1(__FILE__, 1, "Greetings, earthling!"),
                'TEST-MESSAGE-v1' . PHP_EOL . json_encode((object)[ 'origin' => __FILE__, 'id' => 1, "greeting" => "Greetings, earthling!" ])
            ],
        ];
    }
}
