<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Artisan;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalCategories = Category::count();

        $totalOrders = Order::count();
        $totalProducts = Product::count();

        $revenueStatuses = ['Konfirmasi', 'Proses', 'Perpanjangan', 'Selesai'];

        $totalRevenue = Order::whereIn('status', $revenueStatuses)->sum('total');

        $latestOrders = Order::latest()->take(5)->get();

        return view('pages.admin.dashboard', compact(
            'totalCategories',
            'totalOrders',
            'totalProducts',
            'totalRevenue',
            'latestOrders'
        ));
    }

    public function triggerReminder()
    {
        try {
            // Memanggil signature command yang ada di SendRentalReminders.php
            Artisan::call('reminder:email');

            return back()->with('success', 'Email pengingat berhasil dikirim secara manual!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim email: ' . $e->getMessage());
        }
    }
}