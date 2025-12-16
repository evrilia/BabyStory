<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;

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
}