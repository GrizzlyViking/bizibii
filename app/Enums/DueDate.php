<?php

namespace App\Enums;

use Illuminate\Support\Collection;

enum DueDate: string implements EnumInterface
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

    case Daily = 'daily';

    public static function all(): Collection
    {
        return collect([
            self::FirstWorkingDayOfMonth,
            self::FirstOfMonth,
            self::LastWorkingDayOfMonth,
            self::LastDayOfMonth,
            self::FirstDayOfYear,
            self::Monday,
            self::Tuesday,
            self::Wednesday,
            self::Thursday,
            self::Friday,
            self::Saturday,
            self::Sunday,
            self::DateInMonth,
            self::Daily,
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
            self::Daily => 'daily',
            self::DateInMonth => 'custom'
        };
    }

    public function equals(EnumInterface|string $enum): bool
    {
        if ($enum instanceof EnumInterface) {
            return $this->value == $enum->value && $this->name == $enum->name;
        }

        return $this->value == $enum || $this->name == $enum;
    }
}
