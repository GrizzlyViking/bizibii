<?php

namespace App\Http\Livewire;

use App\Models\Transaction;
use Livewire\Component;
use Livewire\WithPagination;

class Transactions extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        return view('livewire.transactions', [
            'transactions' => Transaction::paginate(100)
        ]);
    }
}
