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
 * @property \Illuminate\Database\Eloquent\Collection<\App\Models\Transaction> $transactions
 * @property \Illuminate\Database\Eloquent\Collection<\App\Models\Reality> $checkpoints
 *
 * @method static self updateOrInsert(array $comparison, array $payload)
 */
class Account extends Model implements ListableInterface
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

    public function getColumn1(): string
    {
        return $this->name;
    }

    public function getColumn1Sub(): ?string
    {
        return $this->description;
    }

    public function getColumn2(): ?string
    {
        return $this->balance;
    }

    public function getColumn3(): ?string
    {
        return null;
    }

    public function getColumn4(): ?string
    {
        return null;
    }

    public function getRouteShow(): ?string
    {
        return route('account.edit', $this);
    }

    public function checkpoints(): Relation
    {
        return $this->morphMany(Reality::class, 'checkpointable');
    }
}
