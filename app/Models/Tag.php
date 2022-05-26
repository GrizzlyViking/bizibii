<?php

namespace App\Models;

use App\Enums\Tag as TagEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property TagEnum $type
 * @property Collection|\App\Models\Transaction[] $transactions
 *
 */
class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['type'];
    public $timestamps = false;

    protected $casts = [
        'type' => TagEnum::class
    ];

    public function taggable()
    {
        return $this->morphTo();
    }
}
