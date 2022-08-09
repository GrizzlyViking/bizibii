<?php

namespace App\Http\Controllers;

use App\Enums\Category;
use App\Models\Expense;
use App\Models\Page;
use App\Services\ExpensesWalker;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{

    public function home()
    {

        /** @var Page $page */
        $page = Page::where('slug', 'home')->first();

        return view('home', ['sections' => $page->sections()->get()->keyBy('slug')]);
    }

    public function dashboard()
    {
        // starting from
        $expenses = Auth::user()->accounts->first()->expenses->filter(fn (Expense $expense) => $expense->category->type() != Category::ADMINISTRATIVE);
        $walker = new ExpensesWalker(Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth(), $expenses);
        return view('dashboard', [
            'expenses' => $expenses,
            'walker' => $walker
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        $all = Page::all();
        return response(view('admin.page.list', compact('all')));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return response(view('page.create'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([]);

        Page::create($validated);

        return response()->redirectToRoute('page.list');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return Response
     */
    public function show(Page $page): Response
    {
        return response(view('page.show', compact('page')));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return Response
     */
    public function edit(Page $page): Response
    {
        return \response(view('page.edit'), compact('page'));
    }

    /**
     * @param Request $request
     * @param Page $page
     * @return RedirectResponse
     */
    public function update(Request $request, Page $page)
    {
        $validate = $request->validate([]);
        $page->update($validate);

        return response()->redirectToRoute('page.list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return RedirectResponse
     */
    public function destroy(Page $page): RedirectResponse
    {
        $page->delete();

        return \response()->redirectToRoute('page.list');
    }
}
