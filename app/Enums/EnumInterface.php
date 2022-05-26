<?php

namespace App\Enums;

use Illuminate\Support\Collection;

interface EnumInterface
{
    public static function all(): Collection;
}
