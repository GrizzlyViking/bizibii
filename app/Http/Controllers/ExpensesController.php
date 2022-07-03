<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpensesRequest;
use App\Models\Expense;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $expenses = Auth::user()->expenses;
        return response()->view('admin.expense.list', compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
    public function edit(Expense $expense)
    {
        return view('admin.expense.edit', compact('expense'));
    }

    public function charts(): Response
    {
        $lineChartModel = (new LineChartModel())
                        ->singleLine()
                        ->setAnimated(false)
                        ->setTitle('Balance per Month.')
                        ->addPoint('first', 12)
                        ->addPoint('third', 14)
                        ->addPoint('4th', 4)
                        ->addPoint('second', 2);
        return response()->view('admin.expense.charts.line', compact('lineChartModel'));
    }
}
