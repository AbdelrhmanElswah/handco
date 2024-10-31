<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
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
Route::prefix('admin')->group(function () {

    Route::get('/', function () {
        return Auth::check() ? redirect('/admin') : view('auth.login');
    });

    // Contact Us route
    Route::post('/store/contact-us', [ContactController::class, 'store'])->name('contact-us');

    Route::middleware('auth')->group(function () {
        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('admin');


        Route::post('/about', [AboutUsController::class, 'update'])->name('about.update');

        Route::get('/about/create', [AboutUsController::class, 'create'])->name('about.create');

        Route::post('/about/store', [AboutUsController::class, 'store'])->name('about.store');

        Route::get('/about/edit', [AboutUsController::class, 'edit'])->name('about.edit');

        // Get Contacts
        Route::get('/contact-us', [ContactController::class, 'index'])->name('contact');

    });
});
Auth::routes();
