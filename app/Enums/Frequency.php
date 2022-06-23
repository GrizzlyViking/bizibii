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

    public static function all(): Collection
    {
        return collect([
            self::Monthly, // <- default for dropdown options
            self::Yearly,
            self::Weekly,
            self::Daily,
            self::Every6thMonth,
            self::Every3rdMonth,
        ]);
    }

    public function type(): string
    {
        return match ($this) {
            self::Yearly, self::Monthly, self::Weekly, self::Daily => self::CalendarElement,
            self::Every3rdMonth, self::Every4thMonth, self::Every6thMonth => self::CalendarElementsGrouping
        };
    }

    public function equals(EnumInterface $enum): bool
    {
        return $this->value == $enum->value && $this->name == $enum->name;
    }
}
