<?php

namespace App\Services;

use App\Models\Expense;
use App\Models\User;
use Carbon\CarbonInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use JetBrains\PhpStorm\ArrayShape;

class ExpensesWalker
{
    private CarbonInterface $end;

    private CarbonInterface $now;

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

    protected function process(): self
    {
        $day = clone $this->now;
        $day->toMutable();
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
        return cache()->remember(
            $this->getKey(),
            60 * 60 * 8,
            function () {
                $this->process();
                return $this->data;
            }
        );

    }

    private function getKey(): string
    {
        /** @var User $user */
        $user = $this->expenses->first()->user;
        return str_replace(' ', '_', $user->name ?? 'unknown') . '.' . $this->now->format('Y-m-d') . '.' . $this->end->format('Y-m-d') . '.' . md5($this->expenses->toJson());
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
