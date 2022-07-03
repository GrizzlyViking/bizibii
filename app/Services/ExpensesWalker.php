<?php

namespace App\Services;

use App\Enums\Category;
use App\Models\Account;
use App\Models\Expense;
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

    private float $starting_balance;

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
        while ($day < $this->end) {
            $this->step($day);
            $day->addDay();
        }

        return $this;
    }

    /**
     * @return \Illuminate\Support\Collection<array>
     */
    public function graphBalance(Account $account, string $type = 'daily'): Collection
    {
        switch ($type) {
            case self::DAILY:
            default:
                return $this->daily($account);
            case self::MONTHLY:
                return $this->graphMonthly($account);
        }
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

    public function graphMonthly(?Account $account = null): Collection
    {
        $balance = $account->balance;
        return $this->data->map(fn(Collection $expenses) => $expenses->filter(fn(Expense $expense
        ) => $expense->account_id == $account->id))->map(function (Collection $expenses) use (&$balance) {
            $expenses->each(function (Expense $expense) use (&$balance) {
                $expense->applyCost($balance);
            });
            return $balance;
        })->groupBy(fn ($day, $date) => date_create($date)->format('Y-m'))
            ->map(fn (Collection $month) =>$month->last());
    }

    public function daily(?Account $account = null): Collection
    {
        $balance = $account->balance;
        return $this->data->map(fn(Collection $expenses) => $expenses->filter(fn(Expense $expense
        ) => $expense->account_id == $account->id))->map(function (Collection $expenses) use (&$balance) {
            $expenses->each(function (Expense $expense) use (&$balance) {
                $expense->applyCost($balance);
            });
            return $balance;
        });
    }

}
