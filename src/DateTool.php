<?php

namespace Common\Tool;

use DateTime;

class DateTool
{

    public static function convertToDate(DateTime $d): DateTime
    {
        return (new DateTime)->createFromFormat('Ymd', $d->format('Ymd'))->setTime(0, 0, 0);
    }

    public static function greaterDate(DateTime $d1, DateTime $d2): bool
    {
        return self::convertToDate($d1) > self::convertToDate($d2);
    }

    public static function smallerDate(DateTime $d1, DateTime $d2): bool
    {
        return self::convertToDate($d1) < self::convertToDate($d2);
    }

    public static function sameDate(DateTime $d1, DateTime $d2): bool
    {
        return self::convertToDate($d1) == self::convertToDate($d2);
    }

    public static function greaterOrSameDate(DateTime $d1, DateTime $d2): bool
    {
        return self::convertToDate($d1) >= self::convertToDate($d2);
    }

    public static function smallerOrSameDate(DateTime $d1, DateTime $d2): bool
    {
        return self::convertToDate($d1) <= self::convertToDate($d2);
    }

    public static function inDateRange(DateTime $date, DateTime $periodFrom, DateTime $periodTo): bool
    {
        return self::greaterOrSameDate($date, $periodFrom) && self::smallerOrSameDate($date, $periodTo);
    }

    /**
     * http://stackoverflow.com/questions/14202687/how-can-i-find-overlapping-dateperiods-date-ranges-in-php
     * @return int
     */
    public static function datesOverlap($start_one, $end_one, $start_two, $end_two): int
    {
        if ($start_one <= $end_two && $end_one >= $start_two) { //If the dates overlap
            return min($end_one, $end_two)->diff(max($start_two, $start_one))->days + 1; //return how many days overlap
        }

        return 0; //Return 0 if there is no overlap
    }

    /**
     * Add months _without overlapping_
     * 31/01 + 1 month = 28/02
     *
     * @param DateTime $date
     * @param int $months
     * @return DateTime
     */
    public static function addMonths(DateTime $date, int $months): DateTime
    {
        $startDay = $date->format('j');

        $date->modify("+{$months} month");

        $endDay = $date->format('j');

        if ($startDay != $endDay) {
            $date->modify('last day of last month');
        }

        return $date;
    }

    public static function addDays(DateTime $date, $days): DateTime
    {
        $date->modify(sprintf('+%d day%s', $days, $days > 1 ? 's' : ''));

        return $date;
    }

    public static function removeDays(DateTime $date, $days): DateTime
    {
        $date->modify(sprintf('-%d day%s', $days, $days > 1 ? 's' : ''));

        return $date;
    }

    public static function currentDate(): DateTime
    {
        return new DateTime('today');
    }

    public static function getDaysBetweenDates(DateTime $d1, DateTime $d2)
    {
        $d1 = self::convertToDate($d1);
        $d2 = self::convertToDate($d2);

        return $d1->diff($d2)->days;
    }

    public static function toText(\DateTime $date, string $country): string
    {
        return $date->format('F jS Y');
    }

    public static function valid($data): bool
    {
        return $data instanceof DateTime;
    }

    public static function yesterdayDate(): DateTime
    {
        $yesterday = (new DateTime)->modify('yesterday');

        return self::convertToDate($yesterday);
    }
}