<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeadsController;
use App\Http\Controllers\LeadsController as ControllersLeadsController;
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
    Route::get('/profile/settings', [HomeController::class, 'settings'])->name('profile.settings');
    Route::put('/profile/settings', [HomeController::class, 'updateSettings'])->name('profile.settings.update');

    Route::get('/change-password', [HomeController::class, 'changePassword'])->name('change.password');
    Route::put('/change-password', [HomeController::class, 'updatePassword'])->name('change.password.update');



    Route::resource('/sources', SourceController::class);
    Route::resource('/statuses', StatusController::class);
    Route::resource('/countries', CountryController::class);
    Route::resource('/leads', LeadsController::class);
    Route::patch('/leads/{id}/change-type', [LeadsController::class, 'changeType'])->name('leads.changeType');
    
    Route::resource('/customers', CustomerController::class);
    Route::patch('/customers/{id}/change-type', [CustomerController::class, 'changeType'])->name('customers.changeType');
});
