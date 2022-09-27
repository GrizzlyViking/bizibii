<?php

namespace App\Http\Controllers;

use App\Enums\Category;
use App\Exports\Budget;
use App\Models\Account;
use App\Models\Expense;
use App\Models\User;
use App\Services\ExpensesWalker;
use App\Services\Graph;
use App\Traits\MonthNameTrait;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExpensesController extends Controller
{
    use MonthNameTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(): Response
    {
        /** @var User $user */
        $user = Auth::user();
        if ($user->accounts->isEmpty()) {
            return response()->view('admin.utility.empty', [
                'title' => 'No accounts',
                'message' => 'Please create an account first.'
            ]);
        }

        $lineChartModel = false;
        $expensesBarChart = false;
        $expenses = $user->expenses;
        if ($user->expenses->isNotEmpty()) {
            $lineChartModel = $this->getGraphMultiLine($user->accounts, Carbon::now()->startOfMonth(), Carbon::now()->addYear()->endOfMonth());
            // $lineChartModel = $this->getGraphLine($user->accounts()->where('name', 'shared account')->first(), Carbon::now()->startOfMonth(), Carbon::now()->addYear()->endOfMonth());
            $expensesBarChart = $this->getBarChart($user->accounts, Carbon::now()->startOfMonth(), Carbon::now()->addYear()->endOfMonth());
        }
        return response()->view('admin.expense.list', compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): Response
    {
        return response()->view('admin.expense.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     *
     * @return \Illuminate\View\View
     */
    public function edit(Expense $expense): View
    {
        return view('admin.expense.edit', compact('expense'));
    }

    public function charts(): Response
    {
        /** @var User $user */
        $user = Auth::user();
        $lineChartModel = $this->getGraphLine($user->accounts->first(),  Carbon::now()->startOfYear(),Carbon::now()->endOfYear());

        return response()->view('admin.expense.charts.line', compact('lineChartModel'));
    }

    public function getGraphLine(Account $account, Carbon $startAt, Carbon $endAt): LineChartModel
    {
        $walker = new ExpensesWalker($startAt, $endAt);
        $graph = $account->graphBalance($walker);

        return Graph::lineChart('Balance per Month.', $graph);
    }

    public function getGraphMultiLine(Collection $accounts, Carbon $startAt, Carbon $endAt): LineChartModel
    {
        $graphs = collect();
        $walker = new ExpensesWalker($startAt, $endAt);
        $accounts->each(function (Account $account) use ($walker, &$graphs) {
            $graphs->put($account->name, $account->graphBalanceMonthly($walker));
        });

        return Graph::multiLineChart('Balance per Month.', $graphs->map(function ($graph, $name) {
            return $graph->map(fn ($balance, $date) => [$name, $date, $balance]);
        })->flatten(1));
    }

    protected function getBarChart(mixed $accounts, Carbon $startAt, Carbon $endAt): ColumnChartModel
    {
        $graphs = collect();

        $walker = new ExpensesWalker($startAt, $endAt);
        /** @var Account $budget_account */
        $budget_account = $accounts->first();
        $graphs->put(
            $budget_account->name,
            $budget_account->graphExpensesMonthly($walker)
        );

        $income = collect();
        $accounts->each(function (Account $account) use ($walker, &$income) {
            $income->put($account->name, $account->graphIncomeMonthly($walker));
        });

        $disposable = $graphs->first()->mergeRecursive($income->sumRecursive())->map(fn ($values) => $values[1]-$values[0]);
        $graphs->put('disposable', $disposable);

        return Graph::barChart('Expenses per month', $graphs->map(function ($graph, $name) {
            return $graph->map(fn ($balance, $date) => [$name, $date, $balance]);
        })->flatten(1));
    }

    public function export(): BinaryFileResponse
    {
        return Excel::download(new Budget, 'budget.xlsx');
    }

}
