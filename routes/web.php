<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\SourceController;
use App\Http\Controllers\StatusController;

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'loginForm'])->name('login.form');
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login'); // ✅ ADD THIS
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


    Route::resource('/sources', SourceController::class);
    Route::resource('/statuses', StatusController::class);
    Route::resource('/countries', CountryController::class);
});
