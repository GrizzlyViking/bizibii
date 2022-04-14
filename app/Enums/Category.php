<?php

namespace App\Enums;

use Illuminate\Support\Collection;

enum Category: string implements TaxonomyInterface
{

    case Transport = 'transport';

    case Income = 'income';

    case Entertainment = 'Entertainment';

    case Utilities = 'utilities';

    case Miscellaneous = 'miscellaneous';

    case Communication = 'communication';

    case Financial = 'financial';

    case House = 'house';

    public static function all(): Collection
    {
        return collect([
            self::Transport,
            self::Income,
            self::Entertainment,
            self::Utilities,
            self::Miscellaneous,
            self::Communication,
            self::Financial,
            self::House,
        ]);
    }

}
