<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\TransactionsController;
use App\Models\Page;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

Route::middleware(['auth:sanctum', 'verified'])->prefix('admin')->group(function () {
    Route::name('page.')->group(function () {
        Route::get('pages', [PageController::class, 'index'])->name('list');
        Route::get('pages/create', [PageController::class, 'create'])->name('create');
        Route::get('pages/{page}', [PageController::class, 'show'])->name('show');
        Route::get('pages/{page}/edit', [PageController::class, 'edit'])->name('edit');
        Route::put('pages/{page}', [PageController::class, 'update'])->name('update');
        Route::post('pages', [PageController::class, 'store'])->name('store');
    });

    Route::name('section.')->group(function () {
        Route::get('pages/{page}/sections', [SectionController::class, 'index'])->name('list');
        Route::get('pages/{page}/sections/create', [SectionController::class, 'create'])->name('create');
        Route::get('pages/{page}/sections/{section}', [SectionController::class, 'show'])->name('show');
        Route::get('pages/{page}/sections/{section}/edit', [SectionController::class, 'edit'])->name('edit');
        Route::put('pages/{page}/sections/{section}', [SectionController::class, 'update'])->name('update');
        Route::post('pages/{page}/sections', [SectionController::class, 'store'])->name('store');
        Route::delete('pages/{page}/sections/{section}', [SectionController::class, 'destroy'])->name('destroy');
    });

    Route::name('message.')->group(function () {
        Route::get('message', [MessageController::class, 'index'])->name('list');
        Route::get('message/{message}', [MessageController::class, 'show'])->name('show');
        Route::delete('message/{message}', [MessageController::class, 'destroy'])->name('destroy');
    });

    Route::name('expenses.')->group(function () {
        Route::get('expenses', [ExpensesController::class, 'list'])->name('list');
        Route::get('expenses/{expense}/edit', [ExpensesController::class, 'edit'])->name('edit');
        Route::get('expenses/create', [ExpensesController::class, 'create'])->name('create');
        Route::get('expenses/charts', [ExpensesController::class, 'charts'])->name('charts');
    });

    Route::resource('account', AccountController::class);
    Route::resource('transaction', TransactionsController::class);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
