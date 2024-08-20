<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Auth;
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
    return Auth::check() ? redirect('/admin') : view('auth.login'); 
});

// Contact Us route
Route::post('/store/contact-us', [ContactController::class, 'store'])->name('contact-us');

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::prefix('/admin')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin');

        // Blogs
        Route::prefix('/blogs')->group(function () {
            Route::get('/', [BlogController::class, 'index'])->name('blog');
            Route::get('/create', [BlogController::class, 'create'])->name('blogs.create');
            Route::post('/', [BlogController::class, 'store'])->name('blogs.store');
            Route::get('/{id}/edit', [BlogController::class, 'edit'])->name('blogs.edit');
            Route::put('/{id}', [BlogController::class, 'update'])->name('blogs.update');
            Route::delete('/{id}', [BlogController::class, 'destroy'])->name('blogs.destroy');
        });

        // Portfolio
        Route::prefix('/portofilos')->group(function () {
            Route::get('/', [PortfolioController::class, 'index'])->name('portofilo');
            Route::get('/create', [PortfolioController::class, 'create'])->name('portofilos.create');
            Route::post('/', [PortfolioController::class, 'store'])->name('portofilos.store');
            Route::get('/{id}/edit', [PortfolioController::class, 'edit'])->name('portofilos.edit');
            Route::put('/{id}', [PortfolioController::class, 'update'])->name('portofilos.update');
            Route::delete('/{id}', [PortfolioController::class, 'destroy'])->name('portofilos.destroy');
        });

        // Get Contacts 
        Route::get('/contact-us', [ContactController::class, 'index'])->name('contact');
    });
});

Auth::routes();
