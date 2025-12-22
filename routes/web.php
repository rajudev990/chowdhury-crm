<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class,'loginForm'])->name('login.form');
    Route::get('/login', [AuthController::class,'loginForm'])->name('login'); // ✅ ADD THIS
    Route::post('/login', [AuthController::class,'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class,'dashboard'])->name('dashboard');
    Route::post('/logout', [AuthController::class,'logout'])->name('logout');
});
