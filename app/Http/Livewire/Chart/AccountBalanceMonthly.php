<?php

namespace App\Http\Livewire\Chart;

use App\Services\ExpensesWalker;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class AccountBalanceMonthly extends Component
{
    protected ExpensesWalker $walker;

    public function mount(ExpensesWalker $walker, )
    {
        $this->walker = $walker;
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.chart.account-balance-monthly');
    }
}
