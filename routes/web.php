<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

// Halaman utama
Route::get('/', function () {
    return view('welcome');
});

// Grup untuk rute admin
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');

    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    });
});
