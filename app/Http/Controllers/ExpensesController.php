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
        $expenses = $user->expenses;
        $walker = (new ExpensesWalker($user, Carbon::now()->startOfMonth(),Carbon::now()->addYear()->endOfMonth()))->process();
        $lineChartModel = $this->getGraphMultiLine($user->accounts, $walker);
        $expensesBarChart = $this->getBarChart($user->accounts, $walker);
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
        $walker = (new ExpensesWalker($user, Carbon::now()->startOfYear(),Carbon::now()->endOfYear()))->process();
        $lineChartModel = $this->getGraphLine($user->accounts->first(), $walker);

        return response()->view('admin.expense.charts.line', compact('lineChartModel'));
    }

    public function getGraphLine(Account $account, ExpensesWalker $walker)
    {
        $graph = $walker->graphBalanceMonthly($account);

        $lineChartModel = (new LineChartModel())
            ->singleLine()
            ->setAnimated(false)
            ->setTitle('Balance per Month.');
        $graph->each(function ($balance, $date) use ($lineChartModel) {
            $lineChartModel->addPoint($date, $balance);
        });

        return $lineChartModel;
    }

    public function getGraphMultiLine(Collection $accounts, ExpensesWalker $walker): LineChartModel
    {
        $graphs = collect();
        $accounts->each(function (Account $account) use ($walker, &$graphs) {
            $graphs->put($account->name, $walker->graphBalanceMonthly($account));
        });

        $lineChartModel = (new LineChartModel())
            ->multiLine()
            ->setTitle('Balance per Month.');
        $graphs->each(function ($graph, $name) use ($lineChartModel) {
            $graph->each(function ($balance, $date) use ($name, $lineChartModel) {
                $lineChartModel->addSeriesPoint($name, $this->getMonth($date), $balance);
            });
        });

        return $lineChartModel;
    }

    protected function getBarChart(mixed $accounts, ExpensesWalker $walker): ColumnChartModel
    {
        $graphs = collect();

        /** @var Account $budget_account */
        $budget_account = $accounts->first();
        $graphs->put(
            $budget_account->name,
            $walker->setExcludeCategories(Category::DayToDayConsumption)->graphExpensesMonthly($budget_account)
        );

        $income = collect();
        $accounts->each(function (Account $account) use ($walker, &$income) {
            $income->put($account->name, $walker->graphIncomeMonthly($account));
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
