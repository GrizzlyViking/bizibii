<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpensesRequest;
use App\Models\Expense;
use App\Models\User;
use App\Services\ExpensesWalker;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
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
        $expenses = Auth::user()->expenses;
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
        $balance = new ExpensesWalker($user, Carbon::now()->startOfYear(),Carbon::now()->endOfYear());

        $graph = $balance->process()->graphBalance($user->accounts->first(), ExpensesWalker::MONTHLY);

        $lineChartModel = (new LineChartModel())
                        ->singleLine()
                        ->setAnimated(false)
                        ->setTitle('Balance per Month.');
        $graph->each(function ($balance, $date) use ($lineChartModel) {
            $lineChartModel->addPoint($date, $balance);
        });
        return response()->view('admin.expense.charts.line', compact('lineChartModel'));
    }
}
