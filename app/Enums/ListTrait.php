<?php

namespace App\Enums;

use Illuminate\Support\Collection;

trait ListTrait
{
    public static function all(): Collection
    {
        return collect(self::cases());
    }

    public static function values(): Collection
    {
        return collect(array_column(self::cases(), 'value'));
    }

    public static function enum(string $value): \UnitEnum|bool
    {
        foreach (self::cases() as $case) {
            if ($case->value == $value) return $case;
        }

        return false;
    }
}
