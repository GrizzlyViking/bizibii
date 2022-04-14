<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $bank_account_id
 * @property float $amount
 * @property string $description
 * @property \DateTimeInterface $created_at
 * @property \DateTimeInterface $updated_at
 *
 * @property \App\Models\BankAccount $bankAccount
 */
class Transaction extends Model
{
    use HasFactory;

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class);
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
