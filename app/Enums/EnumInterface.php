<?php

namespace App\Enums;

use Illuminate\Support\Collection;

/**
 * @property string $value
 * @property string $name
 */
interface EnumInterface
{
    public static function all(): Collection;

    public function equals(EnumInterface|string $enum): bool;
}
