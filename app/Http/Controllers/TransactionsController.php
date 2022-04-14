<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionsRequest;
use App\Http\Requests\UpdateTransactionsRequest;
use App\Models\Transaction;

class TransactionsController extends Controller
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
     *
     * @param  \App\Http\Requests\StoreTransactionsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTransactionsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction $transactions
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transactions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transactions
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transactions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTransactionsRequest  $request
     * @param \App\Models\Transaction  $transactions
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTransactionsRequest $request, Transaction $transactions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Transaction  $transactions
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transactions)
    {
        //
    }
}
