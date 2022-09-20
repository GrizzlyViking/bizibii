<?php

namespace App\Http\Livewire;

use App\Enums\Category;
use App\Models\Account;
use App\Models\Expense;
use App\Models\ListableInterface;
use App\Models\User;
use App\Services\ExpensesWalker;
use App\Services\Graph;
use Asantibanez\LivewireCharts\Models\PieChartModel;
use Carbon\CarbonImmutable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\Redirector;

class ListExpenses extends Component
{
    /** @var ListableInterface[]|\Illuminate\Support\Collection */
    public $items;

    public User $user;

    /** @var Carbon $startAt */
    public $startAt;
    /** @var Carbon $endAt */
    public $endAt;

    /** @var Carbon $barChartMonth */
    private $barChartMonth;
    public bool $showPieChart = false;

    public function mount(User $user, Collection $items)
    {
        $this->barChartMonth = CarbonImmutable::now();
        $this->user = $user;
        $this->items = $items->sortBy(fn (Expense $expense) => Category::Income->equals($expense->category) ? -1 : Category::all()->search($expense->category));
    }

    public function render()
    {
        return view('livewire.list-expenses');
    }

    public function handleOnColumnClick($column)
    {
        $walk_months = clone $this->startAt;
        while ($walk_months->monthName != $column['title']) {
            $walk_months->addMonth();
        }
        $this->barChartMonth = $walk_months;
    }

    public function editExpense(int $expense_id): RedirectResponse|Redirector
    {
        return response()->redirectToRoute('expenses.edit', $expense_id);
    }

    public function createExpense(): RedirectResponse|Redirector
    {
        return response()->redirectToRoute('expenses.create');
    }

    public function delete(Expense $expense)
    {
        $expense->delete();

        $this->items = $this->user->expenses;
    }
}
