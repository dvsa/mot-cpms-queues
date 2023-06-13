<?php

namespace DVSA\CPMS\Queues\MultipartMessages\ValueBuilders;

use DVSA\CPMS\Queues\MultipartMessages\Values\TestMessageV1;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass DVSA\CPMS\Queues\MultipartMessages\ValueBuilders\BuildTestMessageV1FromPayload
 */
class BuildTestMessageV1FromPayloadMessageTest extends TestCase
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

        $unit = new BuildTestMessageV1FromPayload;

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(BuildTestMessageV1FromPayload::class, $unit);
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

        $unit = new BuildTestMessageV1FromPayload;

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

        $actualResult = BuildTestMessageV1FromPayload::from($rawMessage);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    public function provideMessagesToDecode()
    {
        return [
            [
                (object)[ 'origin' => __FILE__, 'id' => 1, "greeting" => "Greetings, earthling!" ],
                new TestMessageV1(__FILE__, 1, "Greetings, earthling!")
            ],
        ];
    }
}