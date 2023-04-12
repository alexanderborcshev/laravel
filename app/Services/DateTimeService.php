<?php

namespace App\Services;

use Carbon\Carbon;

class DateTimeService
{
    public static function diffFormat(string|null $date, $withTime = true, $minimumUnit = 'min'): string
    {
        if (!$date) {
            return '';
        }
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $date);
        $dateDiff =  $date->diffForHumans(syntax: ['minimumUnit'=>$minimumUnit], short: true);
        if ($withTime) {
            $dateDiff .= ' в '.$date->format('H:i');
        }
        return str_replace([' д.'],[' дн.'], $dateDiff);
    }

    public static function dateShortTime(string|null $date): string
    {
        if (!$date) {
            return '';
        }
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d.m.Y H:i');
    }
    public static function date(string|null $date): string
    {
        if (!$date) {
            return '';
        }
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d.m.Y');
    }
}
