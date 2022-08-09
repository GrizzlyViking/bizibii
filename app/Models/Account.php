<?php

namespace App\Models;

use App\Enums\Category;
use App\Services\ExpensesWalker;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

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
 * @property \Illuminate\Support\Collection<\App\Models\Expense> $expenses
 * @property \Illuminate\Support\Collection<\App\Models\Expense> $incomingTransfers
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

    public function expenses(): Relation
    {
        return $this->hasMany(Expense::class);
    }

    public function incomingTransfers(): Relation
    {
        return $this->hasMany(Expense::class, 'transfer_to_account_id');
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

    public function graphBalance(ExpensesWalker $walker): Collection
    {
        $balance = $this->balance;

        $expenses = $this->expenses->merge($this->incomingTransfers);
        return $walker->setExpenses($expenses)->getData('account_balance:' . $this->id)->map(function (Collection $expenses, $date) use (&$balance) {
            // If there is a checkpoint for balance for that day, that is used instead.
            // TODO: replace this with relation.
            /** @var Reality $checkpoint */
            if ($checkpoint = Reality::where('checkpointable_id', $this->id)->where('checkpointable_type', self::class)->where('registered_date', $date)->first()) {
                $balance = intval($checkpoint->amount);
            } else {
                $expenses->each(function (Expense $expense) use ($date, &$balance) {
                    if ($expense->category->equals(Category::Transfer) && $expense->account_id != $this->id) {
                        $expense->setDateToCheck($date)->applyTransfer($balance);
                    } else {
                        $expense->setDateToCheck($date)->applyCost($balance);
                    }
                });
            }
            return $balance;
        });
    }

    public function graphBalanceMonthly(ExpensesWalker $walker): Collection
    {
        return $this->graphBalance($walker)->groupBy(fn($day, $date) => date_create($date)->format('Y-m'))
            ->map(fn(Collection $month) => $month->last());
    }

    public function graphExpensesMonthly(ExpensesWalker $walker): Collection
    {
        return $this->graphExpenses($walker)->groupBy(fn($day, $date) => date_create($date)->format('Y-m'))->map(fn(Collection $month) => $month->sum());
    }

    public function graphExpenses(ExpensesWalker $walker): Collection
    {
        $expenses = $this->expenses->filter(fn (Expense $expense) => !$expense->category->equals(Category::DayToDayConsumption) );
        return $walker->setExpenses($expenses)->getData('expenses.account:' . $this->id)
            ->map(function (Collection $expenses, $date) {
                return $expenses->sum(fn(Expense $expense
                ) => $expense->category->equals(Category::Income) ? 0 : -$expense->setDateToCheck($date)->getCost());
            });
    }

    public function graphIncomeMonthly(ExpensesWalker $walker): Collection
    {
        return $walker->setExpenses($this->expenses)->getData('income.account:' . $this->id)->map(function (
            Collection $expenses,
            $date
        ) {
            return $expenses->sum(fn(Expense $expense) => $expense->category->equals(Category::Income) ? $expense->setDateToCheck($date)->getCost() : 0);
        })->groupBy(fn($day, $date) => date_create($date)->format('Y-m'))->map(fn(Collection $month) => $month->sum());
    }
}
