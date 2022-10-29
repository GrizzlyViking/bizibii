<?php

namespace App\Enums;

enum DueDate: string implements EnumInterface
{
    use ListTrait;

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
    case Date = 'specific date';

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
            self::Date,
            self::DateInMonth => 'custom'
        };
    }

    public function equals(mixed $enum): bool
    {
        if ($enum instanceof \UnitEnum) {
            return $this->value == $enum->value && $this->name == $enum->name;
        }

        return $this->value == $enum || $this->name == $enum;
    }
}
