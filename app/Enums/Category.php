<?php

namespace App\Enums;

use Illuminate\Support\Collection;

enum Category: string implements EnumInterface
{

    case Transport = 'transport';

    case Income = 'income';

    case DayToDayConsumption = 'day-to-day consumption';

    case Entertainment = 'entertainment';

    case Utilities = 'utilities';

    case Miscellaneous = 'miscellaneous';

    case Communication = 'communication';

    case Financial = 'financial';

    case House = 'house';

    case Tax = 'tax';

    case Unknown = 'unknown';

    public static function all(): Collection
    {
        return collect([
            self::Transport,
            self::Income,
            self::DayToDayConsumption,
            self::Entertainment,
            self::Utilities,
            self::Miscellaneous,
            self::Communication,
            self::Tax,
            self::Financial,
            self::House,
            self::Unknown,
        ]);
    }

    public function colour(): string
    {
        return match ($this) {
            self::DayToDayConsumption, self::Tax, self::Transport, self::Entertainment, self::Utilities, self::Communication => 'red',
            self::Income => 'green',
            self::House, self::Financial => 'blue',
            self::Miscellaneous => 'purple',
            self::Unknown => 'grey'
        };
    }

    public function comments(): string
    {
        return match ($this) {
            self::DayToDayConsumption => 'The daily consumption should be 5000kr per grown-up and 2500kr per child for a whole month. This is a requirement of a mortgage application.',
            default => '',
        };
    }

    public function equals(EnumInterface $enum): bool
    {
        return $this->value == $enum->value && $this->name == $enum->name;
    }
}
