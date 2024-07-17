<?php

namespace DVSA\CPMS\Queues\MultipartMessages\ValueBuilders;

use DVSA\CPMS\Queues\Exceptions\E4xx_CannotDecodeMessagePayload;
use DVSA\CPMS\Queues\Exceptions\E4xx_EmptyMessageType;
use DVSA\CPMS\Queues\Exceptions\E4xx_InvalidMessageFormat;
use DVSA\CPMS\Queues\MultipartMessages\Maps\MultipartMessageMapper;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass DVSA\CPMS\Queues\MultipartMessages\ValueBuilders\DecodeMultipartMessage
 */
class DecodeMultipartMessageTest extends TestCase
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

        $obj = new DecodeMultipartMessage;

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(DecodeMultipartMessage::class, $obj);
    }

    /**
     * @covers ::__invoke
     * @dataProvider provideMessagesToDecode
     */
    public function testCanUseAsObject($rawMessage, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        $obj = new DecodeMultipartMessage;
        $mapper = new DecodeMultipartMessageTest_TestMapper;

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = $obj($mapper, $rawMessage);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::using
     * @dataProvider provideMessagesToDecode
     */
    public function testCanCallStatically($rawMessage, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        $mapper = new DecodeMultipartMessageTest_TestMapper;

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = DecodeMultipartMessage::using($mapper, $rawMessage);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::using
     */
    public function testThrowsExceptionIfMessageTypeIsEmpty()
    {
        // ----------------------------------------------------------------
        // setup your test

        $this->expectException(E4xx_EmptyMessageType::class);

        $mapper = new DecodeMultipartMessageTest_TestMapper;
        $message = " \n" . '{"origin":"cpms\/cpms-queue"}';

        // ----------------------------------------------------------------
        // perform the change

        DecodeMultipartMessage::using($mapper, $message);
    }

    /**
     * @covers ::using
     */
    public function testThrowsExceptionIfMessagePayloadIsEmpty()
    {
        // ----------------------------------------------------------------
        // setup your test

        $this->expectException(E4xx_InvalidMessageFormat::class);

        $mapper = new DecodeMultipartMessageTest_TestMapper;
        $message = "PAYMENT-NOTIFICATION-V1 " . '{"origin":"cpms\/cpms-queue"}';

        // ----------------------------------------------------------------
        // perform the change

        DecodeMultipartMessage::using($mapper, $message);
    }

    /**
     * @covers ::using
     */
    public function testThrowsExceptionIfMessagePayloadIsNotValidJson()
    {
        // ----------------------------------------------------------------
        // setup your test

        $this->expectException(E4xx_CannotDecodeMessagePayload::class);

        $mapper = new DecodeMultipartMessageTest_TestMapper;
        $message = "PAYMENT-NOTIFICATION-v1\n" . '{"origin":"cpms\/cpms-queue}';

        // ----------------------------------------------------------------
        // perform the change

        DecodeMultipartMessage::using($mapper, $message);
    }


    public function provideMessagesToDecode()
    {
        return [
            [
                "TEST-ENTITY-V1\n" . '{"origin":"cpms\/cpms-queue"}',
                new DecodeMultipartMessageTest_Entity('cpms/cpms-queue')
            ],
        ];
    }
}

class DecodeMultipartMessageTest_Entity
{
    public function __construct($origin)
    {
        $this->origin = $origin;
    }
}

class DecodeMultipartMessageTest_EntityDecoder implements PayloadDecoderFactory
{
    public function __invoke($data)
    {
        return new DecodeMultipartMessageTest_Entity($data->origin);
    }
}

class DecodeMultipartMessageTest_TestMapper extends MultipartMessageMapper
{
    protected $messageTypes = [
        'TEST-ENTITY-V1' => DecodeMultipartMessageTest_EntityDecoder::class,
    ];
}
