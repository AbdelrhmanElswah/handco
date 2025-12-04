<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\website\BlogController;
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
    $aboutPageBanner = \App\Models\CmsSection::getByKey('about_page_banner');
    if ($aboutPageBanner) {
        $aboutPageBanner->load('backgroundImage');
    }

    $aboutHeroBanner = \App\Models\CmsSection::getByKey('about_hero_banner');
    if ($aboutHeroBanner) {
        $aboutHeroBanner->load('backgroundImage');
    }

    $aboutPartners = \App\Models\CmsSection::getByKey('about_partners');

    $missionVisionSection = \App\Models\CmsSection::getByKey('mission_vision_section');
    if ($missionVisionSection) {
        $missionVisionSection->load('backgroundImage');
    }

    return view('website.about', compact('aboutPageBanner', 'aboutHeroBanner', 'aboutPartners', 'missionVisionSection'));
})->name('about');

Route::get('/privacy-policy', function () {
    $privacySection = \App\Models\CmsSection::getByKey('privacy_policy_section');
    if ($privacySection) {
        $privacySection->load('backgroundImage');
    }

    return view('website.privacy', compact('privacySection'));
})->name('privacy');

Route::get('/blogs', [BlogController::class, 'showBlogs'])->name('blogs');

Route::get('/blogs/{id}', [BlogController::class, 'show'])->name('blogs.show');

Route::get('/projects', [ProjectController::class, 'index'])->name('projects');

// Individual project details page route
Route::get('/projects/{id}', [ProjectController::class, 'show'])->name('projects.show');

// Featured projects page route
Route::get('/featured-projects', [ProjectController::class, 'featured'])->name('featured_projects');
