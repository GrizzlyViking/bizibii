<?php

namespace App\Services;

use App\Enums\Category;
use App\Models\Account;
use App\Models\Expense;
use App\Models\Reality;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use JetBrains\PhpStorm\NoReturn;

class ExpensesWalker
{

    public const MONTHLY = 'monthly';

    public const DAILY = 'daily';

    /**
     * @var \App\Models\User
     */
    private User $user;

    private Carbon $end;

    private Carbon $now;

    private Collection $data;

    public function __construct(
        User $user,
        Carbon $start,
        Carbon $end
    ) {
        $this->user = $user;
        $this->now = $start;
        $this->end = $end;
        $this->data = collect();
    }

    public function process(): self
    {
        $day = clone $this->now;
        while ($day <= $this->end) {
            $this->step($day);
            $day->addDay();
        }

        return $this;
    }

    /**
     * @return \Illuminate\Support\Collection<Expense>
     */
    public function getData(): Collection
    {
        return $this->data;
    }

    protected function completed(): array
    {
        return [
            'data'      => $this->data,
            'completed' => 'success',
        ];
    }

    private function step(Carbon $day)
    {
        $expenses = $this->user->expenses->filter(function (Expense $expense) use ($day) {
            return $expense->applicable($day);
        });

        $this->data->put($day->format('Y-m-d'), $expenses);
    }

    public function graphBalance(?Account $account = null): Collection
    {
        $balance = $account->balance;

        return $this->filterExpensesByAccount($account)->map(function (Collection $expenses, $date) use ($account, &$balance) {
            // If there is a checkpoint for balance for that day, that is used instead.
            /** @var Reality $checkpoint */
            if ($checkpoint = Reality::where('checkpointable_id', $account->id)->where('checkpointable_type', $account::class)->where('registered_date', $date)->first()) {
                $balance = $checkpoint->amount;
            } else {
                $expenses->each(function (Expense $expense) use ($date, $account, &$balance) {
                    if ($expense->category->equals(Category::Transfer) && $expense->transfer_to_account_id == $account->id) {
                        $expense->setDateToCheck($date)->applyTransfer($balance);
                    } else {
                        $expense->setDateToCheck($date)->applyCost($balance);
                    }
                });
            }
            return $balance;
        });
    }

    public function graphBalanceMonthly(?Account $account = null): Collection
    {
        return $this->graphBalance($account)->groupBy(fn($day, $date) => date_create($date)->format('Y-m'))
            ->map(fn(Collection $month) => $month->last());
    }

    public function graphExpensesMonthly(Account $account): Collection
    {
        return $this->filterExpensesByAccount($account)->map(function (Collection $expenses) {
            return $expenses->sum(fn(Expense $expense
            ) => $expense->category->equals(Category::Income) || $expense->category->type() == Category::ADMINISTRATIVE ? 0 : -$expense->getCost());
        })->groupBy(fn($day, $date) => date_create($date)->format('Y-m'))->map(fn(Collection $month) => $month->sum());
    }

    public function graphIncomeMonthly(Account $account): Collection
    {
        return $this->filterExpensesByAccount($account)->map(function (Collection $expenses) {
            return $expenses->sum(fn(Expense $expense) => $expense->category->equals(Category::Income) ? $expense->getCost() : 0);
        })->groupBy(fn($day, $date) => date_create($date)->format('Y-m'))->map(fn(Collection $month) => $month->sum());
    }

    public function filterExpensesByAccount(Account $account): Collection
    {
        return $this->data->map(fn(Collection $expenses) => $expenses->filter(fn(Expense $expense
        ) => $expense->account_id == $account->id || ($expense->category->equals(Category::Transfer) && $expense->transfer_to_account_id == $account->id)));
    }

}
