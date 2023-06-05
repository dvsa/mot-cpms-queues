<?php

namespace DVSA\CPMS\Queues\MultipartMessages\ValueBuilders;

/**
 * PayloadEncoderFactory knows how to convert a specific entity into a
 * raw multipart message
 *
 * by design, you need to provide:
 *
 * 1 x PayloadDecoderFactory
 * 1 x PayloadEncoderFactory
 *
 * for each entity that you can map into a multipart message and back again
 *
 * empty interface, used for type-hinting help only
 */
interface PayloadEncoderFactory
{

}