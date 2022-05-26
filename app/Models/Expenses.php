<?php

namespace App\Models;

use App\Enums\Category;
use App\Enums\Frequency;
use App\Enums\DueDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Carbon\CarbonImmutable;

/**
 * @property int $id
 * @property string $description
 * @property Category $category
 * @property float $amount
 * @property boolean $applied
 * @property DueDate $due_date
 * @property string $due_date_meta
 * @property Frequency $frequency
 * @property CarbonImmutable $start
 * @property CarbonImmutable $end
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property \App\Models\User $user
 */
class Expenses extends Model
{

    use HasFactory;

    protected $casts = [
        'applied'   => 'boolean',
        'category'  => Category::class,
        'frequency' => Frequency::class,
        'due_date'  => DueDate::class,
        'start'     => CarbonImmutable::class,
        'end'       => CarbonImmutable::class,
    ];

    protected $fillable = [
        'description',
        'category',
        'frequency',
        'due_date',
        'due_date_meta',
        'amount',
        'applied',
        'start',
        'end',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
