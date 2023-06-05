<?php

namespace DVSA\CPMS\Queues\MultipartMessages\ValueBuilders;

use DVSA\CPMS\Queues\MultipartMessages\Maps\MultipartMessageMapper;

/**
 * PayloadDecoderFactory knows how to convert a raw multipart message
 * into the associated entity
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
interface PayloadDecoderFactory
{
}