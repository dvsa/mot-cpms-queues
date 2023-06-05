<?php

require_once "vendor/autoload.php";

use Aws\Sqs\SqsClient;
use Aws\Credentials\CredentialProvider;
use DVSA\CPMS\Queues\QueueAdapters\AmazonSqs\AmazonSqsQueues;
use DVSA\CPMS\Queues\MultipartMessages\Maps\MapTestMessages;
use DVSA\CPMS\Queues\MultipartMessages\Values\TestMessageV1;

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
            'Middleware' => [
                // converts our objects into strings
                'MultipartMessage' => [
                    "mapper" => MapTestMessages::class,
                ],
                // signs the data to ensure it has not been tampered with
                'Hmac' => [
                    'type' => 'sha256',
                    'key' => 'this is a message signing key'
                ],
                // encrypts the data to avoid prying eyes
                'Encryption' => [
                    "type" => "AES-256-CBC",
                    "key" => "123456789ABCDEF0",
                    "secret" => "0FEDCBA987654321"
                ],
                // ensures the data is ASCII, to keep SQS happy
                'Base64' => [],
            ],
        ],
    ],
];

$queues = new AmazonSqsQueues($config);

for ($seqNo = 0; $seqNo < 10; $seqNo++) {
    $entity = new TestMessageV1(__FILE__, $seqNo, "Greetings, human!");
    $queues->writeMessageToQueue("notifications", $entity);
}

do {
    $qMessages = $queues->receiveMessagesFromQueue("notifications");
    foreach ($qMessages as $qMessage) {
        var_dump($qMessage->getPayload());
        var_dump($qMessage->getMiddlewareSteps());
        $queues->confirmMessageHandled($qMessage);
    }
}
while (!empty($qMessages));