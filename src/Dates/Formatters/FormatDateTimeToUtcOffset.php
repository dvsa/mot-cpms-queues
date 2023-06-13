<?php

namespace DVSA\CPMS\Queues\Dates\Formatters;

use DateTime;

class FormatDateTimeToUtcOffset
{
    /**
     * format a datetime
     *
     * @param  DateTime $date
     *         the date/time we want to format for transmission
     * @return string
     *         the date/time as a string
     */
    public function __invoke(DateTime $date)
    {
        return self::from($date);
    }

    /**
     * format a datetime
     *
     * @param  DateTime $date
     *         the date/time we want to format for transmission
     * @return string
     *         the date/time as a string
     */
    public static function from(DateTime $date)
    {
        return $date->format("Y-m-d H:i:s.u O");
    }
}