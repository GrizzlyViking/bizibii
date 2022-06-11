<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpensesRequest;
use App\Models\Expense;
use Illuminate\Http\Response;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExpenseRequest $request): Response
    {
        $expense = Expense::create($request->validated());

        return response($expense->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expense  $expenses
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expenses)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expense  $expenses
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expenses)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateExpensesRequest  $request
     * @param  \App\Models\Expense  $expenses
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateExpensesRequest $request, Expense $expenses)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expense  $expenses
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expenses)
    {
        //
    }
}
