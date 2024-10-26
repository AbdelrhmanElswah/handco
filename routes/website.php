<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('website.index');
})->name('home');

Route::get('/contact', function () {
    return view('website.contact');
})->name('contact');
