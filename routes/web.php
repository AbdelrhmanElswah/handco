<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
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
    Route::prefix('/admin')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin');

        // Blogs
        Route::prefix('/products')->group(function () {
            Route::get('/', [ProductController::class, 'index'])->name('products');
            Route::get('/create', [ProductController::class, 'create'])->name('products.create');
            Route::post('/', [ProductController::class, 'store'])->name('products.store');
            Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
            Route::put('/{id}', [ProductController::class, 'update'])->name('products.update');
            Route::delete('/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
        });

        Route::delete('/products/media/{id}', [ProductController::class, 'deleteMedia'])->name('products.media.delete');


        // Portfolio
        Route::prefix('/category')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('category');
            Route::get('/create', [CategoryController::class, 'create'])->name('category.create');
            Route::post('/', [CategoryController::class, 'store'])->name('category.store');
            Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');
            Route::put('/{id}', [CategoryController::class, 'update'])->name('category.update');
            Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');
        });


        Route::post('/about', [AboutUsController::class, 'update'])->name('about.update');

        Route::get('/about/create', [AboutUsController::class, 'create'])->name('about.create');

        Route::post('/about/store', [AboutUsController::class, 'store'])->name('about.store');

        Route::get('/about/edit', [AboutUsController::class, 'edit'])->name('about.edit');


        // Get Contacts
        Route::get('/contact-us', [ContactController::class, 'index'])->name('contact');



    });
});
});
Auth::routes();
