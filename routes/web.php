<?php

use App\Http\Controllers\ArticleController;
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

Route::get('/', function () {
    return view('home');
})->name('home');

Route::middleware(['auth:sanctum', 'verified'])->prefix('admin')->group(function () {
    Route::name('article.')->group(function () {
        Route::get('article', [ArticleController::class, 'index'])->name('index');
        Route::post('article', [ArticleController::class, 'store'])->name('store');
        Route::get('article/create', [ArticleController::class, 'create'])->name('create');
        Route::get('article/{article}', [ArticleController::class, 'show'])->name('show');
        Route::put('article/{article}', [ArticleController::class, 'update'])->name('update');
        Route::get('article/{article}/edit', [ArticleController::class, 'edit'])->name('edit');
        Route::delete('article/{article}', [ArticleController::class, 'destroy'])->name('destroy');
    });
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
