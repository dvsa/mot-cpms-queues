<?php

namespace DVSA\CPMS\Queues\MultipartMessages\ValueBuilders;

use DVSA\CPMS\Queues\MultipartMessages\Maps\MultipartMessageMapper;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass DVSA\CPMS\Queues\MultipartMessages\ValueBuilders\EncodeMultipartMessage
 */
class EncodeMultipartMessageMessageTest extends TestCase
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

        $obj = new EncodeMultipartMessage;

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(EncodeMultipartMessage::class, $obj);
    }

    /**
     * @covers ::__invoke
     * @dataProvider provideEntitiesToEncode
     */
    public function testCanUseAsObject($rawMessage, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        $obj = new EncodeMultipartMessage;
        $mapper = new EncodeMultipartMessageTest_TestMapper;

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = $obj($mapper, $rawMessage);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::using
     * @dataProvider provideEntitiesToEncode
     */
    public function testCanCallStatically($rawMessage, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        $mapper = new EncodeMultipartMessageTest_TestMapper;

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = EncodeMultipartMessage::using($mapper, $rawMessage);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    public function provideEntitiesToEncode()
    {
        return [
            [
                new EncodeMultipartMessageTest_Entity('cpms/cpms-queue'),
                "TEST-ENTITY-V1\n" . '{"origin":"cpms\/cpms-queue"}',
            ],
        ];
    }
}

class EncodeMultipartMessageTest_Entity
{
    public function __construct($origin)
    {
        $this->origin = $origin;
    }
}

class EncodeMultipartMessageTest_EntityEncoder implements PayloadEncoderFactory
{
    public function __invoke($entity)
    {
        return "TEST-ENTITY-V1\n" . json_encode(["origin" => $entity->origin]);
    }
}

class EncodeMultipartMessageTest_TestMapper extends MultipartMessageMapper
{
    protected $entities = [
        EncodeMultipartMessageTest_Entity::class => EncodeMultipartMessageTest_EntityEncoder::class,
    ];
}