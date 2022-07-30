<?php

namespace App\Services;

use App\Models\Expense;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use JetBrains\PhpStorm\ArrayShape;

class ExpensesWalker
{
    private Carbon $end;

    private Carbon $now;

    private Collection $data;

    protected array $excludeCategories = [];

    /** @var \Illuminate\Support\Collection<Expense>
     */
    protected Collection $expenses;

    public function __construct(
        Carbon $start,
        Carbon $end
    ) {
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

    public function setExpenses(Collection $expenses): self
    {
        $this->expenses = $expenses;

        return $this;
    }

    /**
     * @return \Illuminate\Support\Collection<Expense>
     */
    public function getExpenses(): Collection
    {
        return $this->expenses;
    }

    /**
     * @return \Illuminate\Support\Collection<Expense>
     */
    public function getData(): Collection
    {
        return $this->data;
    }

    #[ArrayShape([
        'data' => Collection::class,
        'completed' => "string"
    ])]
    protected function completed(): array
    {
        return [
            'data'      => $this->data,
            'completed' => 'success',
        ];
    }

    private function step(Carbon $day): void
    {
        $expenses = $this->expenses->filter(function (Expense $expense) use ($day) {
            return $expense->applicable($day);
        });

        $this->data->put($day->format('Y-m-d'), $expenses);
    }

}
