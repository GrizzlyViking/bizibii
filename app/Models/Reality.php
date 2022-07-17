<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * @property int $item_id
 * @property string $item_type
 * @property float $amount
 * @property CarbonInterface $registered_date
 * @property string $checkpoint_date
 */
class Reality extends Model
{
    use HasFactory;

    protected $fillable = ['checkpointable_id', 'checkpointable_type', 'amount', 'registered_date'];
    protected $dates = [
        'registered_date'
    ];
    protected $appends = [
        'checkpoint_date'
    ];

    public function checkpointable(): Relation
    {
        return $this->morphTo();
    }

    public function checkpointDate(): Attribute
    {
        return new Attribute(
            get: fn () => $this->registered_date->format('Y-m-d')
        );
    }
}
