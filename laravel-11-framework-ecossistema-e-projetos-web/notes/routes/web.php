<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Middleware\CheckIsGuest;
use App\Http\Middleware\CheckIsLogged;
use Illuminate\Support\Facades\Route;

Route::middleware([CheckIsGuest::class])->group(function() {
    Route::get('/login', [AuthController::class, 'login']);
    Route::post('/login', [AuthController::class, 'submit']);
});

Route::middleware([CheckIsLogged::class])->group(function() {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/', [MainController::class, 'index'])->name('home');
    Route::get('/new-note', [MainController::class, 'new_note'])->name('new');
    Route::post('/new-note', [MainController::class, 'new_note_submit'])->name('new_note_submit');
    Route::get('/edit-note/{id}', [MainController::class, 'edit_note'])->name('edit');
    Route::post('/edit-note', [MainController::class, 'edit_note_submit'])->name('edit_note_submit');
    Route::get('/delete-note/{id}', [MainController::class, 'delete_note'])->name('delete');
    Route::get('/delete-note-confirm/{id}', [MainController::class, 'delete_note_confirm'])->name('delete_note_confirm');
});

