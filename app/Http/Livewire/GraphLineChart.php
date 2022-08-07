<?php

namespace App\Http\Livewire;

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

    public function mount(Collection $expenses)
    {
        $this->expenses = $expenses;
        $this->startAt = Carbon::now()->startOfMonth();
        $this->endAt = Carbon::now()->startOfMonth();
    }

    public function render(): View
    {
        $lineChart = Graph::getAccumulateExpenses($this->expenses, $this->startAt, $this->endAt);
        return view('livewire.graph-line-chart', compact('lineChart'));
    }
}
