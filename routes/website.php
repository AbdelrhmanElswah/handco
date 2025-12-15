<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\website\BlogController;
use App\Http\Controllers\website\HomeController;
use App\Http\Controllers\website\ProjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Sell page - CMS driven sections
Route::get('/sell', function () {
    $sellPageBanner = \App\Models\CmsSection::getByKey('sell_page_banner');
    if ($sellPageBanner) {
        $sellPageBanner->load('backgroundImage');
    }

    $sellHeroBanner = \App\Models\CmsSection::getByKey('sell_hero_banner');
    if ($sellHeroBanner) {
        $sellHeroBanner->load('backgroundImage');
    }

    $sellStepsSection = \App\Models\CmsSection::getByKey('sell_steps_section');

    $sellCtaSection = \App\Models\CmsSection::getByKey('sell_cta_section');
    if ($sellCtaSection) {
        $sellCtaSection->load('backgroundImage');
    }

    return view('website.sell', compact(
        'sellPageBanner',
        'sellHeroBanner',
        'sellStepsSection',
        'sellCtaSection'
    ));
})->name('sell');

Route::get('/buy', function() {
    return redirect()->route('home', ['listingType' => 'buy']);
})->name('buy');
Route::get('/rent', function() {
    return redirect()->route('home', ['listingType' => 'rent']);
})->name('rent');
Route::get('/off-plan', function() {
    return redirect()->route('home', ['listingType' => 'off-plan']);
})->name('off-plan');

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

// Off Plan Listing page route
Route::get('/off-plan-listing', [ProjectController::class, 'offPlanListing'])->name('off_plan_listing');

// Off Plan Project detail page route
Route::get('/off-plan-projects/{id}', [ProjectController::class, 'showOffPlanProject'])->name('off-plan-project.show');