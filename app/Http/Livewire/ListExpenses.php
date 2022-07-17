<?php

namespace App\Http\Livewire;

use App\Models\Expense;
use App\Models\ListableInterface;
use App\Models\User;
use App\Services\ExpensesWalker;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
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

    public function mount(User $user)
    {
        $this->user = $user;
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
