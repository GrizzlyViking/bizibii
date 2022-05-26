<?php

namespace App\Enums;

use Illuminate\Support\Collection;

enum Frequency: string implements EnumInterface
{
    case Yearly = 'yearly';

    case Monthly = 'monthly';

    case Every6Month = 'every 6 month';

    case Every3Month = 'every 3 month';

    case Weekly = 'weekly';

    public static function all(): Collection
    {
        return collect([
            self::Yearly,
            self::Monthly,
            self::Weekly,
            self::Every6Month,
            self::Every3Month,
        ]);
    }

}
