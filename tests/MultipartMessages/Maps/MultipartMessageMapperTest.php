<?php

namespace DVSA\CPMS\Queues\MultipartMessages\Maps;

use DVSA\CPMS\Queues\Exceptions\E4xx_UnsupportedEntityType;
use DVSA\CPMS\Queues\Exceptions\E4xx_UnsupportedMessageType;
use DVSA\CPMS\Queues\MultipartMessages\ValueBuilders\PayloadDecoderFactory;
use DVSA\CPMS\Queues\MultipartMessages\ValueBuilders\PayloadEncoderFactory;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @coversDefaultClass DVSA\CPMS\Queues\MultipartMessages\Maps\MultipartMessageMapper
 */
class MultipartMessageMapperTest extends TestCase
{
    /**
     * @covers ::mapMessageTypeToFactory
     * @dataProvider provideMessageTypes
     */
    public function testCanMapMessageTypeToFactory($messageType, $expectedClass)
    {
        // ----------------------------------------------------------------
        // setup your test

        $mapper = new MultipartMessageMapper_TestMapper;

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = $mapper->mapMessageTypeToFactory($messageType);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf($expectedClass, $actualResult);
    }

    /**
     * @covers ::mapEntityToFactory
     * @dataProvider provideEntities
     */
    public function testCanMapEntityToFactory($entity, $expectedClass)
    {
        // ----------------------------------------------------------------
        // setup your test

        $mapper = new MultipartMessageMapper_TestMapper;

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = $mapper->mapEntityToFactory($entity);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf($expectedClass, $actualResult);
    }

    /**
     * @covers ::mapMessageTypeToFactory
     */
    public function testThrowsExceptionForUnknownMessageType()
    {
        // ----------------------------------------------------------------
        // setup your test

        $this->expectException(E4xx_UnsupportedMessageType::class);

        $mapper = new MultipartMessageMapper_TestMapper;

        // ----------------------------------------------------------------
        // perform the change

        $mapper->mapMessageTypeToFactory("UNKNOWN");
    }

    /**
     * @covers ::mapEntityToFactory
     */
    public function testThrowsExceptionForUnsupportedEntity()
    {
        // ----------------------------------------------------------------
        // setup your test

        $this->expectException(E4xx_UnsupportedEntityType::class);

        $entity = new stdClass;
        $mapper = new MultipartMessageMapper_TestMapper;

        // ----------------------------------------------------------------
        // perform the change

        $mapper->mapEntityToFactory($entity);

        // ----------------------------------------------------------------
        // test the results
        //
        // explain what you expect to have happened

        $this->markTestIncomplete('Not yet implemented');
    }


    public function provideMessageTypes()
    {
        return [
            [ 'TEST-TYPE-V1', MultipartMessageMapper_TestEntityDecoder1::class ],
            [ 'TEST-TYPE-V2', MultipartMessageMapper_TestEntityDecoder2::class ],
        ];
    }

    public function provideEntities()
    {
        return [
            [ new MultipartMessageMapper_TestEntity1(null), MultipartMessageMapper_TestEntityEncoder1::class ],
            [ new MultipartMessageMapper_TestEntity2(null), MultipartMessageMapper_TestEntityEncoder2::class ],
        ];
    }
}

class MultipartMessageMapper_TestEntity1
{
    public function __construct($data)
    {
        $this->data = $data;
    }
}

class MultipartMessageMapper_TestEntity2
{
    public function __construct($data)
    {
        $this->data = $data;
    }
}

class MultipartMessageMapper_TestEntityDecoder1 implements PayloadDecoderFactory
{

}

class MultipartMessageMapper_TestEntityEncoder1 implements PayloadEncoderFactory
{

}

class MultipartMessageMapper_TestEntityDecoder2 implements PayloadDecoderFactory
{

}

class MultipartMessageMapper_TestEntityEncoder2 implements PayloadEncoderFactory
{

}

class MultipartMessageMapper_TestMapper extends MultipartMessageMapper
{
    protected $messageTypes = [
        'TEST-TYPE-V1' => MultipartMessageMapper_TestEntityDecoder1::class,
        'TEST-TYPE-V2' => MultipartMessageMapper_TestEntityDecoder2::class,
    ];

    protected $entities = [
        MultipartMessageMapper_TestEntity1::class => MultipartMessageMapper_TestEntityEncoder1::class,
        MultipartMessageMapper_TestEntity2::class => MultipartMessageMapper_TestEntityEncoder2::class,
    ];
}