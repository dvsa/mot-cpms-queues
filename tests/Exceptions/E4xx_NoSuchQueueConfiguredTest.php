<?php

namespace DVSA\CPMS\Queues\Exceptions;

use Exception;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass DVSA\CPMS\Queues\Exceptions\E4xx_NoSuchQueueConfigured
 */
class E4xx_NoSuchQueueConfiguredTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanInstantiate()
    {
        // ----------------------------------------------------------------
        // setup your test

        $queueName = "scheme-notifications";

        // ----------------------------------------------------------------
        // perform the change

        $obj = new E4xx_NoSuchQueueConfigured($queueName);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(E4xx_NoSuchQueueConfigured::class, $obj);
    }

    /**
     * @covers ::__construct
     */
    public function testIsException()
    {
        // ----------------------------------------------------------------
        // setup your test

        $queueName = "scheme-notifications";

        // ----------------------------------------------------------------
        // perform the change

        $obj = new E4xx_NoSuchQueueConfigured($queueName);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(Exception::class, $obj);
    }

    /**
     * @covers ::__construct
     */
    public function testHasErrorCode400()
    {
        // ----------------------------------------------------------------
        // setup your test

        $queueName = "scheme-notifications";
        $expectedCode = 400;

        // ----------------------------------------------------------------
        // perform the change

        $obj = new E4xx_NoSuchQueueConfigured($queueName);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedCode, $obj->getCode());
    }

}