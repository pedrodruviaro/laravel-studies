<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MainController::class, 'index']);
Route::get('/one_to_one', [MainController::class, 'one_to_one']);
Route::get('/belongs_to', [MainController::class, 'one_to_many']);
Route::get('/belongs_to', [MainController::class, 'belongs_to']);
Route::get('/collections', [MainController::class, 'many_to_many']);
Route::get('/collections', [MainController::class, 'collections']);
