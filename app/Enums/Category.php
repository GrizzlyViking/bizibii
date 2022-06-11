<?php

namespace App\Enums;

use Illuminate\Support\Collection;

enum Category: string implements EnumInterface
{

    case Transport = 'transport';

    case Income = 'income';

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
            Category::Tax, Category::Transport, Category::Entertainment, Category::Utilities, Category::Communication => 'red',
            Category::Income => 'green',
            Category::House, Category::Financial => 'blue',
            Category::Miscellaneous => 'purple',
            self::Unknown => 'grey'
        };
    }

    public function equals(EnumInterface $enum): bool
    {
        return $this->value == $enum->value && $this->name == $enum->name;
    }
}
