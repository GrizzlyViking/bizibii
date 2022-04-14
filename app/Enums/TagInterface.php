<?php

namespace App\Enums;

use Illuminate\Support\Collection;

interface TagInterface
{
    public function category(): Category;

    public static function all(): Collection;
}
