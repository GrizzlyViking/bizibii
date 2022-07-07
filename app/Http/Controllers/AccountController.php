<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): Response
    {
        $accounts = Auth::user()->accounts;
        return response()->view('admin.account.list', compact('accounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): Response
    {
        return response()->view('admin.account.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Account  $account
     *
     * @return View
     */
    public function edit(Account $account): View
    {
        return view('admin.account.edit', compact('account'));
    }
}
