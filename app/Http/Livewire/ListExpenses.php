<?php

namespace App\Http\Livewire;

use App\Models\Expense;
use App\Models\ListableInterface;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ListExpenses extends Component
{
    /** @var ListableInterface[]|\Illuminate\Support\Collection */
    public $items;

    public function render()
    {
        return view('livewire.list-expenses');
    }

    public function delete(Expense $expense)
    {

        $items = $this->items->filter(function (Expense $exp) use ($expense) {
            return $exp->id != $expense->id;
        });

        $this->items = $items;

        $expense->delete();
    }
}
