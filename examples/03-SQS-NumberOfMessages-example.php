<?php

require_once "vendor/autoload.php";

use Aws\Sqs\SqsClient;
use Aws\Credentials\CredentialProvider;
use DVSA\CPMS\Queues\QueueAdapters\AmazonSqs\AmazonSqsQueues;
use DVSA\CPMS\Queues\MultipartMessages\Maps\MultipartMessageMapper;
use DVSA\CPMS\Queues\MultipartMessages\ValueBuilders\DecodeMultipartMessage;
use DVSA\CPMS\Queues\MultipartMessages\ValueBuilders\EncodeMultipartMessage;
use DVSA\CPMS\Queues\MultipartMessages\ValueBuilders\PayloadDecoderFactory;
use DVSA\CPMS\Queues\MultipartMessages\ValueBuilders\PayloadEncoderFactory;

// ==================================================================
//
// our example entity
//
// ------------------------------------------------------------------

class TestNotificationV1
{
    public $date;
    public $sequence;

    public function __construct($date, $sequence)
    {
        $this->date = $date;
        $this->sequence = $sequence;
    }
}

// ==================================================================
//
// Our factories to convert between a multipart message and
// our entity
//
// ------------------------------------------------------------------

class BuildTestNotificationV1FromPayload implements PayloadDecoderFactory
{
    public function __invoke($payload)
    {
        return new TestNotificationV1($payload->date, $payload->sequence);
    }
}

class BuildMessageForTestNotificationV1 implements PayloadEncoderFactory
{
    public function __invoke(TestNotificationV1 $entity)
    {
        return "TEST-NOTIFICATION-V1\n"
               . json_encode((object)['date' => $entity->date, 'sequence'=>$entity->sequence]);
    }
}

// ==================================================================
//
// Our mapper, to tell the encoder and decoder which factory to
// use
//
// ------------------------------------------------------------------

class MapMessages extends MultipartMessageMapper
{
    protected $messageTypes = [
        'TEST-NOTIFICATION-V1' => BuildTestNotificationV1FromPayload::class,
    ];

    protected $entities = [
        TestNotificationV1::class => BuildMessageForTestNotificationV1::class
    ];
}

// ==================================================================
//
// Putting it all together
//
// ------------------------------------------------------------------

$queueUrl = "https://sqs.us-west-2.amazonaws.com/600499240829/SH_Test01";

$config = [
    "region" => "us-west-2",
    "queues" => [
        "notifications" => [
            "QueueUrl" => $queueUrl,
        ],
    ],
    "http" => [
        "proxy" => "http://127.0.0.1:3128",
    ],
];

$queues = new AmazonSqsQueues($config);
$mapper = new MapMessages;

for ($seqNo = 0; $seqNo < 10; $seqNo++) {
    $entity = new TestNotificationV1(time(), $seqNo);
    $message = EncodeMultipartMessage::using($mapper, $entity);
    $queues->writeMessageToQueue("notifications", $message);
}

$queueLength = $queues->getNumberOfMessagesInQueue("notifications");
echo "SQS queue 'notifications' now contains approx. {$queueLength} messages" . PHP_EOL;

do {
    $qMessages = $queues->receiveMessagesFromQueue("notifications");
    foreach ($qMessages as $qMessage) {
        // var_dump($qMessage);
        $entity = DecodeMultipartMessage::using($mapper, $qMessage->getRawContents());
        // var_dump($entity);
        $queues->confirmMessageHandled($qMessage);
    }
}
while (!empty($qMessages));

$queueLength = $queues->getNumberOfMessagesInQueue("notifications");
echo "SQS queue 'notifications' now contains approx. {$queueLength} messages" . PHP_EOL;
