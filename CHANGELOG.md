# CHANGELOG

## develop branch

Nothing yet.

## 1.10.0 - Thu 28th April 2016

### New

* Added `UnexpectedPayload` as a way to handle bad SQS payloads

## 1.9.0 - Tue 26th April 2016

### New

* Added support for JSON encoding / decoding via middleware
  * Added `BuildJsonMiddleware`
  * Added `JsonEncodePayload`
  * Added `JsonDecodePayload`

## 1.8.0 - Mon 18th April 2016

### New

* Added support for generating unique message IDs
  * Brought over `GenerateNotificationId` from `cpms-notifications` to be `GenerateMessageId`
  * Added `E5xx_CannotGenerateMessageId`

## 1.7.0 - Thu 7th April 2016

### New

* Added support for debugging 'middleware'
  * Added QueueMessage::getMiddlewareSteps() - returns a list of decoders used, with inputs and outputs shown

## 1.6.0 - Tue 5th April 2016

### New

* Added support for 'middleware' - modules to modify / format messages when they are written to / read from the queues
* Added encryption / decryption middleware modules
* Added base64 encode / decode middleware modules
* Added message signing / verification middleware modules

## 1.5.0 - Wed 27th January 2016

### New

* Added support for connecting to SQS via an HTTP proxy
  * `AmazonSqsQueues` adapter now accepts the (optional) SQS 'http' config setting

## 1.4.3 - Wed 6th January 2016

* Updated composer.json to use AWS git repositories for dependencies

## 1.4.2 - Fri Dec 04 2015

### New

* Added support for emptying queues.
  * `Queues::purgeQueue()` added
  * `QueueAdapters\Interfaces\QueuePurger` added
  * `AmazonSqsQueue::purgeQueue()` added
  * `AmazonSqs\PurgeQueue` added
  * `InMemoryQueue::purgeQueue()` added
  * `InMemory\PurgeQueue` added

## 1.4.1 - Fri Nov 13 2015

### Fixes

* Make the `InMemoryQueues` adapter easier to drop-in for testing
  * Make in-memory queues active by default

## 1.4.0 - Fri Nov 13 2015

### New

* Added ability to inspect a queue to find out how many messages it has.
  * `QueueAdapters\Interfaces\QueueLengthInspector` added
  * `Queues::getNumberOfMessagesInQueue()` added
  * `AmazonSqsQueues::getNumberOfMessagesInQueue()` added
  * `AmazonSqs\GetNumberOfMessages` added
  * `examples/03-SQS-NumberOfMessages-example.php` added
  * `InMemoryQueues::getNumberOfMessagesInQueue()` added
  * `InMemory\GetNumberOfMessages` added
  * `examples/03-InMemory-NumberOfMessages-example.php` added

## 1.3.0 - Thu Nov 12 2015

### New

* Added `InMemoryQueues` to help with unit-testing apps (e.g. CPMS) that use queues.
  * `InMemory\ConfirmMessageHandled` added
  * `InMemory\InMemoryQueue` added
  * `InMemory\InMemoryQueues` added
  * `InMemory\ReceiveNextMessage` added
  * `InMemory\WriteMessage` added

## 1.2.0 - Wed Nov 11 2015

### New

* Added several helper methods for reading/writing/confirming messages:
  * `Queues::receiveMessagesFromQueue()` added
  * `Queues::writeMessageToQueue()` added
  * `Queues::confirmMessageHandled()` added
  * `AmazonSqsQueues::receiveMessagesFromQueue()` added
  * `AmazonSqsQueues::writeMessageToQueue()` added
  * `AmazonSqsQueues::confirmMessageHandled()` added

## 1.1.0 - Wed Nov 11 2015

### New

* `AmazonSqsQueues` - support for explicit authentication config
* `AmazonSqsQueues` - support for authentication config in environment
* `AmazonSqsQueues` - support for multiple profiles in credentials file
* Added `FormatDateTimeToUtcOffset` - converts DateTime objects to a string for transmission via the queues

### Fixes

* Added missing docblocks & inline comments to classes

## 1.0.0 - Tue Nov 10 2015

Initial release, so that `cpms-notifications` and `cpms-frontend` can start building on it.

### New

* Added `E4xx_CannotDecodeMessagePayload` exception
* Added `E4xx_EmptyMessageType` exception
* Added `E4xx_InvalidMessageFormat` exception
* Added `E4xx_NoSuchQueueConfigured` exception
* Added `E4xx_UnsupportedEntityType` exception
* Added `E4xx_UnsupportedMessageType` exception
* Added `DecodeMultipartMessage` helper
* Added `EncodeMultipartMessage` helper
* Added `MultipartMessageMapper` helper
* Added `PayloadDecoderFactory` interface
* Added `PayloadEncoderFactory` interface
* Added `QueueAdapters\AmazonSqs`
* Added `QueueAdapters\Interfaces`
* Added `QueueAdapters\Values`
