<?php

namespace DVSA\CPMS\Queues\MultipartMessages\Values;

use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass DVSA\CPMS\Queues\MultipartMessages\Values\TestMessageV1
 */
class TestMessageV1Test extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanInstantiate()
    {
        // ----------------------------------------------------------------
        // setup your test

        $origin = __FILE__;
        $id = __LINE__;
        $greeting = "Greetings, earthling!";

        // ----------------------------------------------------------------
        // perform the change

        $unit = new TestMessageV1($origin, $id, $greeting);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(TestMessageV1::class, $unit);
    }

    /**
     * @covers ::getOrigin
     */
    public function testCanGetOrigin()
    {
        // ----------------------------------------------------------------
        // setup your test

        $expectedOrigin = __FILE__;
        $expectedId = __LINE__;
        $expectedGreeting = "Greetings, earthling!";

        $unit = new TestMessageV1($expectedOrigin, $expectedId, $expectedGreeting);

        // ----------------------------------------------------------------
        // perform the change

        $actualOrigin = $unit->getOrigin();

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedOrigin, $actualOrigin);
    }

    /**
     * @covers ::getId
     */
    public function testCanGetId()
    {
        // ----------------------------------------------------------------
        // setup your test

        $expectedOrigin = __FILE__;
        $expectedId = __LINE__;
        $expectedGreeting = "Greetings, earthling!";

        $unit = new TestMessageV1($expectedOrigin, $expectedId, $expectedGreeting);

        // ----------------------------------------------------------------
        // perform the change

        $actualId = $unit->getId();

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedId, $actualId);
    }

    /**
     * @covers ::getGreeting
     */
    public function testCanGetGreeting()
    {
        // ----------------------------------------------------------------
        // setup your test

        $expectedOrigin = __FILE__;
        $expectedId = __LINE__;
        $expectedGreeting = "Greetings, earthling!";

        $unit = new TestMessageV1($expectedOrigin, $expectedId, $expectedGreeting);

        // ----------------------------------------------------------------
        // perform the change

        $actualGreeting = $unit->getGreeting();

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedGreeting, $actualGreeting);
    }

}