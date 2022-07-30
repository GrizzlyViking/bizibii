<?php

namespace App\Http\Controllers;

use App\Enums\Category;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpensesRequest;
use App\Models\Account;
use App\Models\Expense;
use App\Models\User;
use App\Services\ExpensesWalker;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ExpensesController extends Controller
{
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
            $expensesBarChart = $this->getBarChart($user->accounts, Carbon::now()->startOfMonth(), Carbon::now()->addYear()->endOfMonth());
        }
        return response()->view('admin.expense.list', compact('expenses', 'lineChartModel', 'expensesBarChart'));
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
        $graph = $account->graphBalanceMonthly($startAt,$endAt);

        $lineChartModel = (new LineChartModel())
            ->singleLine()
            ->setAnimated(false)
            ->setTitle('Balance per Month.');
        $graph->each(function ($balance, $date) use ($lineChartModel) {
            $lineChartModel->addPoint($date, $balance);
        });

        return $lineChartModel;
    }

    protected function getBarChart(mixed $accounts, Carbon $startAt, Carbon $endAt): ColumnChartModel
    {
        $graphs = collect();

        /** @var Account $budget_account */
        $budget_account = $accounts->first();
        $graphs->put(
            $budget_account->name,
            $budget_account->graphExpensesMonthly($startAt, $endAt)
        );

        $income = collect();
        $accounts->each(function (Account $account) use ($endAt, $startAt, &$income) {
            $income->put($account->name, $account->graphIncomeMonthly($startAt, $endAt));
        });

        $disposable = $graphs->first()->mergeRecursive($income->sumRecursive())->map(fn ($values) => $values[1]-$values[0]);
        $graphs->put('disposable', $disposable);

        $barChart = (new ColumnChartModel())
            ->multiColumn()
            ->stacked()
            ->setTitle('Expenses per month');
        $graphs->each(function ($graph, $name) use ($barChart) {
            $graph->each(function ($expenses, $date) use ($name, $barChart) {
                $barChart->addSeriesColumn($name, $this->getMonth($date), $expenses);
            });
        });

        return $barChart;
    }

    private function getMonth(string $yearMonth): string
    {
        if (preg_match('/(\d{4})-(\d{2})/', $yearMonth, $matched)) {
            return Carbon::create($matched[1], $matched[2], '1')->monthName;
        }

        return $yearMonth;
    }

}
