<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $item_id
 * @property string $item_type
 * @property float $checkpoint
 * @property \Illuminate\Support\Carbon $registered_date
 */
class Reality extends Model
{
    use HasFactory;

    protected $fillable = ['checkpointable_id', 'checkpointable_type', 'checkpoint', 'registered_date'];
    protected $dates = [
        'registered_date'
    ];

    public function checkpointable()
    {
        return $this->morphTo();
    }
}
