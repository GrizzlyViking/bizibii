<?php

namespace App\Enums;

use Illuminate\Support\Collection;

enum Frequency: string implements EnumInterface
{
    public const CalendarElement = 'calendar element';

    public const CalendarElementsGrouping = 'calendar elements grouping';

    case Yearly = 'yearly';

    case Monthly = 'monthly';

    case Every6thMonth = 'every 6th month';

    case Every3rdMonth = 'every 3rd month';

    case Every4thMonth = 'every 4th month';

    case Weekly = 'weekly';

    case Daily = 'daily';

    case Single = 'one time only';

    public static function all(): Collection
    {
        return collect([
            self::Monthly, // <- default for dropdown options
            self::Weekly,
            self::Daily,
            self::Yearly,
            self::Every6thMonth,
            self::Every3rdMonth,
            self::Single,
        ]);
    }

    public function type(): string
    {
        return match ($this) {
            self::Yearly, self::Monthly, self::Weekly, self::Daily, self::Single => self::CalendarElement,
            self::Every3rdMonth, self::Every4thMonth, self::Every6thMonth => self::CalendarElementsGrouping
        };
    }

    public function equals(EnumInterface|string|null $enum): bool
    {
        if ($enum instanceof EnumInterface) {
            return $this->value == $enum->value && $this->name == $enum->name;
        }

        return $this->value == $enum || $this->name == $enum;
    }
}
