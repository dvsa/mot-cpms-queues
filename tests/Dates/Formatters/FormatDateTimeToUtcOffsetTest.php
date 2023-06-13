<?php

namespace DVSA\CPMS\Queues\Dates\Formatters;

use DateTime;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass DVSA\CPMS\Queues\Dates\Formatters\FormatDateTimeToUtcOffset
 */
class FormatDateTimeToUtcOffsetTest extends TestCase
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

        $obj = new FormatDateTimeToUtcOffset;

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(FormatDateTimeToUtcOffset::class, $obj);
    }

    /**
     * @covers ::__invoke
     * @dataProvider provideDateTimesToTest
     */
    public function testCanUseAsObject($dateTime, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        $obj = new FormatDateTimeToUtcOffset;

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = $obj($dateTime);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::from
     * @dataProvider provideDateTimesToTest
     */
    public function testCanCallStatically($dateTime, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = FormatDateTimeToUtcOffset::from($dateTime);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    public function provideDateTimesToTest()
    {
        return [
            [ new DateTime("2004-02-12T15:19:21+00:00"), "2004-02-12 15:19:21.000000 +0000" ],
        ];
    }
}