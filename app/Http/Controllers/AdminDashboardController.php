<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // sementara, isi nilai default
        $totalUsers = 0;
        $totalOrders = 0;
        $totalProducts = 0;
        $totalRevenue = 0;
        $latestOrders = [];

        return view('pages.admin.dashboard', compact(
            'totalUsers',
            'totalOrders',
            'totalProducts',
            'totalRevenue',
            'latestOrders'
        ));
        // $totalUsers = User::count();
        // $totalOrders = Order::count();
        // $totalProducts = Product::count();
        // $totalRevenue = Order::sum('total');

        // $latestOrders = Order::with(['user', 'product'])
        //     ->latest()
        //     ->take(5)
        //     ->get();

        // return view('pages.admin.dashboard', compact(
        //     'totalUsers',
        //     'totalOrders',
        //     'totalProducts',
        //     'totalRevenue',
        //     'latestOrders'
        // ));
    }
}
