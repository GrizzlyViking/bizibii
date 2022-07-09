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

    private ?User $user;

    /**
     * @var \Asantibanez\LivewireCharts\Models\LineChartModel
     */
    public LineChartModel $lineChartModel;

    public \Closure $graph;

    /**
     * @var \App\Services\ExpensesWalker
     */
    private ExpensesWalker $walker;

    public function mount()
    {
        $this->user = Auth::user();
        $this->walker = (new ExpensesWalker($this->user, Carbon::now()->startOfYear(),Carbon::now()->endOfYear()))->process();
    }

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

    public function generateLineChart(): LineChartModel
    {
        $graph = $this->walker->process()->graphBalanceMonthly($this->user->accounts->first());

        $this->lineChartModel = (new LineChartModel())
            ->singleLine()
            ->setAnimated(false)
            ->setTitle('Balance per Month.');

        $graph->each(function ($balance, $date) {
            $this->lineChartModel->addPoint($date, $balance);
        });

        return $this->lineChartModel;
    }
}
