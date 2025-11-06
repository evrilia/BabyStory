<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\StatisticController;
use App\Http\Controllers\NotificationController;

// Halaman utama
Route::get('/', function () {
    return view('welcome');
});

// ===========================
// Rute untuk ADMIN
// ===========================
Route::prefix('admin')->name('admin.')->group(function () {

    // --- AUTH ---
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
    Route::get('/change-password', [AdminController::class, 'showChangePasswordForm'])->name('change-password.form');
    Route::post('/change-password', [AdminController::class, 'changePassword'])->name('change-password.update');


    // --- Hanya untuk admin yang sudah login ---
    Route::middleware('auth:admin')->group(function () {

        // DASHBOARD
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // ===================
        // ORDERS
        // ===================
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [AdminOrderController::class, 'index'])->name('index');
            Route::get('/create', [AdminOrderController::class, 'create'])->name('create');
            Route::post('/', [AdminOrderController::class, 'store'])->name('store');
        });

        // ===================
        // CATEGORIES
        // ===================
        Route::prefix('kategori')->name('categories.')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('index');
            Route::get('/create', [CategoryController::class, 'create'])->name('create');
            Route::post('/', [CategoryController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('edit');   // ✨ Tambahan
            Route::put('/{id}', [CategoryController::class, 'update'])->name('update');    // ✨ Tambahan
            Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('destroy'); // ✨ Opsional
        });

        // ===================
        // PRODUCTS
        // ===================

        Route::prefix('products')->name('products.')->group(function () {
            Route::get('/', [ProductController::class, 'index'])->name('index');          // → admin.products.index
            Route::get('/create', [ProductController::class, 'create'])->name('create');  // → admin.products.create
            Route::post('/', [ProductController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('edit');
            Route::put('/{id}', [ProductController::class, 'update'])->name('update');
            Route::delete('/{id}', [ProductController::class, 'destroy'])->name('destroy');
            Route::get('/{id}', [ProductController::class, 'show'])->name('show');
            Route::get('/admin/products/search', [ProductController::class, 'search']);

        });
        // ===================
        // STATISTICS
        // ===================
        Route::get('/statistics', [StatisticController::class, 'index'])->name('statistics.index');

        // ===================
        // NOTIFICATIONS
        // ===================
        Route::prefix('notifications')->name('notifications.')->group(function () {
            Route::get('/', [NotificationController::class, 'index'])->name('index');
            Route::post('/{id}/read', [NotificationController::class, 'markAsRead'])->name('read');
        });
    });
});
