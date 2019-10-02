<?php

namespace Rulla\Utils;

use Carbon\Carbon;
use DateTime;

class Date
{
    /**
     * @param $datetime string|DateTime
     * @return string|null
     */
    public static function format($datetime)
    {
        if ($datetime === null) {
            return null;
        }

        if (is_string($datetime)) {
            $datetime = Carbon::createFromTimeString($datetime, config('app.timezone'));
        }

        $carbon = Carbon::instance($datetime)
            ->setTimezone(env('TIMEZONE', 'UTC'));

        return $carbon->toDateTimeString() . ' ' . strtoupper($carbon->getTimezone()->getAbbreviatedName());
    }
}
