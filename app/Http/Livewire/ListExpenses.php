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
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Redirector;

class ListExpenses extends Component
{
    public User $user;

    public array $sortBy = [];

    public ?string $filterByAccount = null;

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.list-expenses', [
            'items' => Auth::user()->expenses()->when($this->filterByAccount > 0, function ($query) {
                return $query->where('account_id', $this->filterByAccount);
            })->when(!empty($this->sortBy), function ($query) {
                $query->orderBy($this->sortBy['column'], $this->sortBy['direction']);
            })->get()
        ]);
    }

    public function sortBy($type)
    {
        if (!empty($this->sortBy['column']) && $this->sortBy['column'] == $type) {
            $this->sortBy['direction'] == 'asc' ? $this->sortBy['direction'] = 'desc' : $this->sortBy = [];
        } else {
            $this->sortBy['column'] = $type;
            $this->sortBy['direction'] = 'asc';
        }
    }

    public function toggleFilterByAccount()
    {
        switch ($this->filterByAccount) {
            default:
                $this->filterByAccount = 1;
                break;
            case 1:
                $this->filterByAccount = 2;
                break;
            case 2:
                $this->filterByAccount = 0;
                break;
        }
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
