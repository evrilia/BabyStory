<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\StatisticController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\User\HomeController;

/*
|--------------------------------------------------------------------------
| Route USER (Public)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('user.home');

// Kategori
Route::get('/category/{id}', [CategoryController::class, 'show'])->name('category.show');

// Produk Detail
Route::get('/product/{id}', [HomeController::class, 'showProduct'])->name('product.show');


/*
|--------------------------------------------------------------------------
| Route ADMIN
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {

    // --- AUTH ADMIN ---
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

    // Change Password
    Route::get('/change-password', [AdminController::class, 'showChangePasswordForm'])->name('change-password.form');
    Route::post('/change-password', [AdminController::class, 'changePassword'])->name('change-password.update');


    // --- PROTECTED ROUTES (Hanya Admin Login) ---
    Route::middleware('auth:admin')->group(function () {

        // DASHBOARD
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // ===================
        // ORDERS (PESANAN)
        // ===================
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [AdminOrderController::class, 'index'])->name('index');
            Route::get('/create', [AdminOrderController::class, 'create'])->name('create');
            Route::post('/', [AdminOrderController::class, 'store'])->name('store');

            // Halaman Edit
            Route::get('/{id}/edit', [AdminOrderController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminOrderController::class, 'update'])->name('update');
            Route::patch('/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('updateStatus');
        });

        // ===================
        // CATEGORIES
        // ===================
        Route::prefix('kategori')->name('categories.')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('index');
            Route::get('/create', [CategoryController::class, 'create'])->name('create');
            Route::post('/', [CategoryController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('edit');
            Route::put('/{id}', [CategoryController::class, 'update'])->name('update');
            Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('destroy');
        });

        // ===================
        // PRODUCTS
        // ===================
        Route::prefix('products')->name('products.')->group(function () {
            // 1. Rute Statis (Harus di atas ID)
            Route::get('/', [ProductController::class, 'index'])->name('index');
            Route::get('/create', [ProductController::class, 'create'])->name('create');
            Route::post('/', [ProductController::class, 'store'])->name('store');

            // 2. Rute Dinamis (Mengandung ID)
            Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('edit');
            Route::put('/{id}', [ProductController::class, 'update'])->name('update');
            Route::delete('/{id}', [ProductController::class, 'destroy'])->name('destroy');
            Route::get('/{id}', [ProductController::class, 'show'])->name('show');
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

        // ===================
        // SETTINGS
        // ===================
        Route::get('/settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
    });
});