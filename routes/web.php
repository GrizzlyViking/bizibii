<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SectionController;
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
        Route::get('article/create', [ArticleController::class, 'create'])->name('create');
        Route::get('article/{article}', [ArticleController::class, 'show'])->name('show');
        Route::get('article/{article}/edit', [ArticleController::class, 'edit'])->name('edit');
        Route::put('article/{article}', [ArticleController::class, 'update'])->name('update');
        Route::post('article', [ArticleController::class, 'store'])->name('store');
        Route::delete('article/{article}', [ArticleController::class, 'destroy'])->name('destroy');
    });

    Route::name('page.')->group(function () {
        Route::get('pages', [PageController::class, 'index'])->name('index');
        Route::get('pages/create', [PageController::class, 'create'])->name('create');
        Route::get('pages/{page}', [PageController::class, 'show'])->name('show');
        Route::get('pages/{page}/edit', [PageController::class, 'edit'])->name('edit');
        Route::put('pages/{page}', [PageController::class, 'update'])->name('update');
        Route::post('pages', [PageController::class, 'store'])->name('store');
    });

    Route::name('section.')->group(function () {
        Route::get('pages/{page}/sections', [SectionController::class, 'index'])->name('index');
        Route::get('pages/{page}/sections/create', [SectionController::class, 'create'])->name('create');
        Route::get('pages/{page}/sections/{section}', [SectionController::class, 'show'])->name('show');
        Route::get('pages/{page}/sections/{section}/edit', [SectionController::class, 'edit'])->name('edit');
        Route::put('pages/{page}/sections/{section}', [SectionController::class, 'update'])->name('update');
        Route::post('pages/{page}/sections', [SectionController::class, 'store'])->name('store');
        Route::delete('pages/{page}/sections/{section}', [SectionController::class, 'destroy'])->name('destroy');
    });
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
