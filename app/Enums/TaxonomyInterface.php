<?php

namespace App\Enums;

use Illuminate\Support\Collection;

interface TaxonomyInterface
{
    public static function all(): Collection;
}
