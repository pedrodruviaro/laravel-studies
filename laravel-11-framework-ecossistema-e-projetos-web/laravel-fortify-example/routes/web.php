<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->middleware(['auth']);


Route::get('/contact', function () {
    return view('contact');
})->name('contact');
