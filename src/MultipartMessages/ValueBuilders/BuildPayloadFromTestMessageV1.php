<?php

namespace DVSA\CPMS\Queues\MultipartMessages\ValueBuilders;

use DVSA\CPMS\Queues\MultipartMessages\ValueBuilders\PayloadEncoderFactory;
use DVSA\CPMS\Queues\MultipartMessages\Values\TestMessageV1;

class BuildPayloadFromTestMessageV1 implements PayloadEncoderFactory
{

    /**
     * create a multipart message from TestMessageV1 entity
     *
     * @param TestMessageV1 $entity
     *        the entity to turn into a multipart message
     *
     * @return string
     *         the multipart message
     */
    public function __invoke(TestMessageV1 $entity)
    {
        return self::from($entity);
    }

    /**
     * create a multipart message from TestMessageV1 entity
     *
     * @param TestMessageV1 $entity
     *        the entity to turn into a multipart message
     *
     * @return string
     *         the multipart message
     */
    public static function from(TestMessageV1 $entity)
    {
        $payload = [
            'origin' => $entity->getOrigin(),
            'id' => $entity->getId(),
            'greeting' => $entity->getGreeting(),
        ];

        return "TEST-MESSAGE-v1\n" . json_encode($payload);
    }
}