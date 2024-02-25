<?php

namespace App\Helpers;

use DateTime;

class DateHelpers
{
    /**
     * Sum days to a datetime;
     *
     * @param  DateTime $datetime
     * @param int $days
     * @return DateTime
     */
    static function sumDays(DateTime $datetime, int $days): DateTime
    {
        $newDatetime = clone $datetime;

        return $newDatetime->modify("+$days days");
    }
}
