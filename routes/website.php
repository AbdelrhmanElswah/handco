<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\website\HomeController;
use App\Http\Controllers\website\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/contact', function () {
    return view('website.contact');
})->name('contact');

Route::post('/contact/store',
    [ContactController::class, 'store'])
    ->name('contacts.store');

Route::post('/booking',
    [BookingController::class, 'store'])
    ->name('booking.store');

Route::get('/about-us', function () {
    return view('website.about');
})->name('about');

Route::get('/blogs', function () {
    return view('website.blogs');
})->name('blogs');

Route::get('/projects', [ProjectController::class, 'index'])->name('projects');

// Individual project details page route
Route::get('/projects/{id}', [ProjectController::class, 'show'])->name('projects.show');

// Featured projects page route
Route::get('/featured-projects', [ProjectController::class, 'featured'])->name('featured_projects');
