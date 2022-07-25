<?php

namespace App\Http\Livewire;

use App\Enums\Category;
use App\Models\Expense;
use App\Models\ListableInterface;
use App\Models\User;
use App\Services\ExpensesWalker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Livewire\Component;

class ListExpenses extends Component
{
    /** @var ListableInterface[]|\Illuminate\Support\Collection */
    public $items;

    private User $user;

    /**
     * @var \App\Services\ExpensesWalker
     */
    private ExpensesWalker $walker;

    public function mount(User $user, Collection $items)
    {
        $this->user = $user;
        $this->items = $items->sortBy(fn (Expense $expense) => Category::Income->equals($expense->category) ? -1 : Category::all()->search($expense->category));
        $this->walker = (new ExpensesWalker($this->user, Carbon::now()->startOfYear(),Carbon::now()->endOfYear()))->process();
    }

    public function render()
    {
        return view('livewire.list-expenses');
    }

    public function delete(Expense $expense)
    {
        $expense->delete();

        $this->items = $this->user->expenses;
    }
}
