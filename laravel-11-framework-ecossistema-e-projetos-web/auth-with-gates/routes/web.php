<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

Route::get('/loginAdmin', [AuthController::class, 'loginAsAdmin'])->name('loginAsAdmin');
Route::get('/loginGuest', [AuthController::class, 'loginAsGuest'])->name('loginAsGuest');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/admin', [AuthController::class, 'onlyAdmins'])->name('admin');
Route::get('/guest', [AuthController::class, 'onlyGuests'])->name('guests');
