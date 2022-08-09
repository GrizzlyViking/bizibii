<?php

namespace App\Http\Livewire;

use App\Enums\Category;
use App\Models\Expense;
use App\Services\ExpensesWalker;
use App\Services\Graph;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

class GraphLineChart extends Component
{

    protected Collection $expenses;
    protected Carbon $startAt;
    protected Carbon $endAt;

    /**
     * @var \App\Services\ExpensesWalker
     */
    protected ExpensesWalker $walker;

    public function mount(Collection $expenses)
    {
        $this->expenses = $expenses;
        $this->startAt = Carbon::now()->startOfMonth();
        $this->endAt = Carbon::now()->startOfMonth();
        $this->walker = (new ExpensesWalker($this->startAt, $this->endAt, $expenses));
    }

    public function render(): View
    {
        $lineChart = Graph::lineChart('Accumulating expenses.', $this->data);
        return view('livewire.graph-line-chart', compact('lineChart'));
    }

    protected function getAccumulateExpenses()
    {
        return $this->walker->getData()->map(
            fn (Collection $expenses) => $expenses->reject(
                fn (Expense $expense) => $expense->category->equals(Category::Income) || $expense->category->type() == Category::ADMINISTRATIVE
            )
        );
    }
}
