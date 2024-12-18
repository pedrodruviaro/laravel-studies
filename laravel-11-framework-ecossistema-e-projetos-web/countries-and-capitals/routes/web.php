<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::controller(MainController::class)->group(function () {
    Route::get('/', 'start_game')->name('start_game');
    Route::post('/', 'prepare_game')->name('prepare_game');
    Route::get('/game', 'game')->name('game');
    Route::get('/answer/{answer}', 'answer')->name('answer');
    Route::get('/next_question', 'next_question')->name('next_question');
    Route::get('/show_results', 'show_results')->name('show_results');
});
