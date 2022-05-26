<?php

namespace App\Enums;

use Illuminate\Support\Collection;

enum DueDate: string
{

    case FirstOfMonth = 'first day of month';

    case FirstWorkingDayOfMonth = 'first working day of month';

    case LastDayOfMonth = 'last day of month';

    case LastWorkingDayOfMonth = 'last working day of month';

    case FirstDayOfYear = 'first day of year';

    case Monday = 'monday';

    case Tuesday = 'tuesday';

    case Wednesday = 'wednesday';

    case Thursday = 'thursday';

    case Friday = 'friday';

    case Saturday = 'saturday';

    case Sunday = 'sunday';

    case DateInMonth = 'first working day after date in month';

    public static function all(): Collection
    {
        return collect([
            self::FirstOfMonth,
            self::FirstWorkingDayOfMonth,
            self::LastDayOfMonth,
            self::LastWorkingDayOfMonth,
            self::FirstDayOfYear,
            self::Monday,
            self::Tuesday,
            self::Wednesday,
            self::Thursday,
            self::Friday,
            self::Saturday,
            self::Sunday,
            self::DateInMonth,
        ]);
    }

    public function type(): string
    {
        return match ($this) {
            self::FirstOfMonth,
            self::FirstWorkingDayOfMonth,
            self::LastDayOfMonth,
            self::FirstDayOfYear,
            self::LastWorkingDayOfMonth => 'relative',
            self::Monday,
            self::Tuesday,
            self::Wednesday,
            self::Thursday,
            self::Friday,
            self::Saturday,
            self::Sunday => 'weekday',
            self::DateInMonth => 'custom'
        };
    }

}
