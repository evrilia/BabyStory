<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Kirim data notifikasi ke setiap tampilan header admin
        View::composer('pages.admin.header', function ($view) {
            $notifications = [];
            $hasNotifications = false;

            // Pastikan admin sedang login
            if (Auth::guard('admin')->check()) {
                $notifications = Notification::where('user_id', Auth::id())
                    ->latest()
                    ->take(5)
                    ->get();

                $hasNotifications = $notifications->where('is_read', false)->count() > 0;
            }

            // Kirim variabel ke view header
            $view->with(compact('notifications', 'hasNotifications'));
        });
    }
}
