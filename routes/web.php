<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UtilityController;
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
        Route::get('/contact-us', [ContactController::class, 'index'])->name('contact-us.index');

        Route::prefix('categories')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('category.index'); // Show all categories
            Route::get('/create', [CategoryController::class, 'create'])->name('category.create'); // Show form to add a new category
            Route::post('/', [CategoryController::class, 'store'])->name('category.store'); // Store new category
            Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('category.edit'); // Show form to edit category
            Route::put('/{category}', [CategoryController::class, 'update'])->name('category.update'); // Update category
            Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('category.destroy'); // Delete category
        });


        Route::prefix('utilities')->group(function () {
            Route::get('/', [UtilityController::class, 'index'])->name('utilities.index'); // Show all utilities
            Route::get('/create', [UtilityController::class, 'create'])->name('utilities.create'); // Show form to add a new utility
            Route::post('/', [UtilityController::class, 'store'])->name('utilities.store'); // Store new utility
            Route::get('/{utility}/edit', [UtilityController::class, 'edit'])->name('utilities.edit'); // Show form to edit utility
            Route::put('/{utility}', [UtilityController::class, 'update'])->name('utilities.update'); // Update utility
            Route::delete('/{utility}', [UtilityController::class, 'destroy'])->name('utilities.destroy'); // Delete utility
        });


        Route::prefix('projects')->group(function () {
            Route::get('/', [ProjectController::class, 'index'])->name('projects.index'); // Show all projects
            Route::get('/create', [ProjectController::class, 'create'])->name('projects.create'); // Show form to add a new project
            Route::post('/', [ProjectController::class, 'store'])->name('projects.store'); // Store new project
            Route::get('/{project}', [ProjectController::class, 'show'])->name('projects.show'); // Show a single project
            Route::get('/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit'); // Show form to edit project
            Route::put('/{project}', [ProjectController::class, 'update'])->name('projects.update'); // Update project
            Route::delete('/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy'); // Delete project
        });

        // Routes for Booking
        Route::prefix('bookings')->group(function () {
            Route::get('/', [BookingController::class, 'index'])->name('booking.index');

            Route::get('/export', [BookingController::class, 'exportToCSV'])->name('bookings.export');

        });

// Routes for Blog
        Route::prefix('blogs')->group(function () {
            Route::get('/', [BlogController::class, 'index'])->name('blog.index');
            Route::get('/create', [BlogController::class, 'create'])->name('blog.create');
            Route::post('/', [BlogController::class, 'store'])->name('blog.store');
            Route::get('/{blog}/edit', [BlogController::class, 'edit'])->name('blog.edit');
            Route::put('/{blog}', [BlogController::class, 'update'])->name('blog.update');
            Route::delete('/{blog}', [BlogController::class, 'destroy'])->name('blog.destroy');
        });


    });
});
Auth::routes();
