<?php

namespace App\Traits;

use Illuminate\Support\Carbon;

trait MonthNameTrait
{
    function getMonth(string $yearMonth): string
    {
        if (preg_match('/(\d{4})-(\d{2})/', $yearMonth, $matched)) {
            return Carbon::create($matched[1], $matched[2], '1')->monthName;
        }

        return $yearMonth;
    }
}
