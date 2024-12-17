<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::controller(MainController::class)->group(function(){
    Route::get('/', 'home')->name('home');
    Route::post('/generate-exercises', 'generate_exercises')->name('generate_exercises');
    Route::get('/print-exercises', 'print_exercises')->name('print_exercises');
    Route::get('/export-exercises', 'export_exercises')->name('export_exercises');
});