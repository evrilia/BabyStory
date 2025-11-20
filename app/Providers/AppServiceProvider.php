<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Kirim data notifikasi ke header admin
        View::composer('pages.admin.header', function ($view) {
            $notifications = [];
            $hasNotifications = false;

            // PERBAIKAN: Cek spesifik guard 'admin'
            if (Auth::guard('admin')->check()) {
                // Ambil ID Admin yang sedang login
                $adminId = Auth::guard('admin')->id();

                $notifications = Notification::where('user_id', $adminId)
                    ->latest()
                    ->take(5)
                    ->get();

                $hasNotifications = $notifications->where('is_read', false)->count() > 0;
            }

            $view->with(compact('notifications', 'hasNotifications'));
        });
    }
}