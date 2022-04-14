<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 *
 * @property \App\Models\Transaction[] $transactions
 *
 */
class Tag extends Model
{
    use HasFactory;

    protected $primaryKey = 'name';
    public $incrementing = false;

    protected $fillable = ['name'];

    protected $casts = [
        'name' => \App\Enums\Tag::class
    ];

    public function transactions()
    {
        return $this->morphedByMany(Transaction::class, 'taggable');
    }

    public function accounts()
    {
        return $this->morphedByMany(BankAccount::class, 'taggable');
    }
}
