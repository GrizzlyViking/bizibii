<?php

namespace App\Services;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class ExpensesWalker
{

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
        Carbon $end,
        ?float $starting_balance = null
    ) {
        $this->user = $user;
        $this->now = $start;
        $this->end = $end;
        $this->starting_balance = ($starting_balance ?: $this->user->bankAccounts->first()->balance ?? 0);
        $this->data = collect();
    }

    public function process()
    {
        $balance = $this->starting_balance;
        $day = clone $this->now;
        while ($day < $this->end) {
            $this->step($day, $balance);
            $day->addDay();
        }

        return $this->completed();
    }

    /**
     * @return \Illuminate\Support\Collection<array>
     */
    public function getGraph(): Collection
    {
        return $this->data->map(function ($expenses) {
            return [
                'cost' => $expenses['expenses']->count() != 0 ? $expenses['expenses']->sum(fn (Expense $expense) => $expense->getCost()) : 0,
                'balance' => $expenses['balance']
            ];
        });
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
            'data' => $this->data,
            'completed' => 'success'
        ];
    }

    /**
     * @param  Carbon  $day
     *  Day being assessed, whether it has any expenses
     *
     * @param  float  $balance
     *
     * @return void
     */
    private function step(Carbon $day, float &$balance)
    {
        $expenses = $this->user->expenses->filter(function (Expense $expense) use (&$balance, $day) {
            try {
                if ($expense->applicable($day)) {
                    $balance -= $expense->getCost();
                    return true;
                }
            } catch (\Exception $e) {
                return false;
            }
        });

        $this->data->put($day->format('Y-m-d'), [
            'expenses' => $expenses,
            'balance' => $balance,
        ]);
    }

}
