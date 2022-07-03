<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $description
 * @property float $balance
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 *
 * @property \App\Models\User $user
 * @property \Illuminate\Database\Eloquent\Collection<\App\Models\Tag> $tags
 * @property \Illuminate\Database\Eloquent\Collection<\App\Models\Transaction>
 *     $transactions
 */
class Account extends Model
{
    protected $table = 'accounts';
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'balance',
    ];

    public function user(): Relation
    {
        return $this->belongsTo(User::class);
    }

    public function tags(): Relation
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function transactions(): Relation
    {
        return $this->hasMany(Transaction::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function addFunds(float $amount): float
    {
        $this->update([
            'balance' => $this->balance + $amount
        ]);

        return $this->balance;
    }
}
