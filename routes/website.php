<?php

use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('website.index');
})->name('home');

Route::get('/contact', function () {
    return view('website.contact');
})->name('contact');

Route::post('/contact/store',
    [ContactController::class, 'store'])
    ->name('contacts.store');

Route::get('/about-us', function () {
    return view('website.about');
})->name('about');

Route::get('/blogs', function () {
    return view('website.blogs');
})->name('blogs');

Route::get('/projects', function () {
    return view('website.projects');
})->name('projects');

Route::get('/projects/{slug}', function ($slug) {
    $project = [
        "slug" => "Dubai-123-Al-Fahidi-Street",
        "payment" => "Installment",
        "tag" => "Hot Sale",
        "image" => "property-grid-2.png",
        "price" => "420,000",
        "address" => "Dubai, 123 Al Fahidi Street",
        "address_link" => "https://maps.google.com",
        "category" => "Villa",
        "title" => "Luxury Villa With Pool",
        "date" => "Oct 21, 2024",
    ];
    return view('website.projects_show', ['project' => $project]);
})->name('projects.show');
