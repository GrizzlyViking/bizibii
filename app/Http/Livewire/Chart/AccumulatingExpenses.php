<?php

namespace App\Http\Livewire\Chart;

use App\Enums\Category;
use App\Models\Expense;
use App\Services\ExpensesWalker;
use App\Services\Graph;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Livewire\Component;

class AccumulatingExpenses extends Component
{
    private ExpensesWalker $walker;

    public function mount(ExpensesWalker $walker)
    {
        $this->walker = $walker;
    }

    public function render(): Application|Factory|View
    {
        $expense_amount = 0.0;
        $chart_data = $this->walker->getData()->map(
            fn (Collection $expenses) => $expenses->reject(
                fn (Expense $expense) => $expense->category->equals(Category::Income) || $expense->category->type() == Category::ADMINISTRATIVE
            )
        )->map(function (Collection $expenses, $date) use (&$expense_amount) {
            return [
                'standard account',
                $date,
                $expense_amount += $expenses->sum(fn (Expense $expense) => abs($expense->setDateToCheck($date)->getCost()))
            ];
        });

        $chart = Graph::lineChart('Expenses Accumulated over month', $chart_data);
        $date = Carbon::now()->format('Y-m-d');
        $chart = $chart->addMarker($date, (int) $chart_data->get($date)[2], 'red', 'Today');
        return view('livewire.chart.accumulating-expenses', compact('chart'));
    }
}
