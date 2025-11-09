<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil semua kategori
        $categories = Category::all();

        // Ambil produk terbaru (pagination)
        $products = Product::latest()->paginate(12);

        // Kirim data ke view
        return view('pages.user.home', compact('categories', 'products'));
    }

    public function showProduct($id)
    {
        $product = Product::findOrFail($id);
        return view('pages.user.produk', compact('product'));
    }
}