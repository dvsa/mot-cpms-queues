<?php

namespace DVSA\CPMS\Queues\Middleware\Checks;

class IsValidHmacType
{
    /**
     * is the given hmac algorithm supported by this version of PHP?
     *
     * @param  string $hmacType
     *         the algorithm to check
     * @return boolean
     *         TRUE if it is supported
     *         FALSE otherwise
     */
    public function __invoke($hmacType)
    {
        return self::check($hmacType);
    }

    /**
     * is the given hmac algorithm supported by this version of PHP?
     *
     * @param  string $hmacType
     *         the algorithm to check
     * @return boolean
     *         TRUE if it is supported
     *         FALSE otherwise
     */
    public static function check($hmacType)
    {
        $supportedAlgos = hash_algos();
        return in_array($hmacType, $supportedAlgos);
    }
}