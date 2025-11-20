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
        // Menghitung total users (Asumsi semua user adalah pelanggan)
        $totalUsers = User::count();
        
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        
        // Menghitung total revenue dari order yang 'Selesai' (Logic bisnis standar)
        $totalRevenue = Order::where('status', 'Selesai')->sum('total');

        // Ambil 5 order terbaru
        $latestOrders = Order::latest()->take(5)->get();

        return view('pages.admin.dashboard', compact(
            'totalUsers',
            'totalOrders',
            'totalProducts',
            'totalRevenue',
            'latestOrders'
        ));
    }
}