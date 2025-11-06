<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    // Menampilkan daftar pesanan
    public function index()
    {
        $orders = Order::orderBy('order_date', 'desc')->paginate(10);
        return view('pages.admin.order.orders', compact('orders'));
    }

    // Form tambah pesanan
    public function create()
    {
        return view('pages.admin.order.create-orders');
    }

    // Simpan pesanan baru
    public function store(Request $request)
    {
       $validated = $request->validate([    
            'order_code' => 'required|unique:orders',
            'customer_name' => 'required',
            'alamat' => 'required',
            'product_name' => 'required',
            'lama_sewa' => 'required',
            'biaya_pengiriman' => 'required',
            'order_date' => 'required|date',
            'status' => 'required',
            'total' => 'required|numeric',
            'no_hp' => 'required|digits_between:12,13|numeric',
        ]);
        // Upload KTP jika ada
        if ($request->hasFile('ktp')) {
            $validated['ktp'] = $request->file('ktp')->store('ktp', 'public');
        }

        $subtotal = 0; // nanti bisa otomatis dari harga produk kalau sudah ada relasi
        $total = $subtotal + $request->biaya_pengiriman;

        Order::create([
            'order_code' => $validated['order_code'],
            'nama_pelanggan' => $validated['nama_pelanggan'],
            'no_hp' => $validated['no_hp'],
            'alamat' => $validated['alamat'],
            'nama_produk' => $validated['nama_produk'],
            'lama_sewa' => $validated['lama_sewa'],
            'biaya_pengiriman' => $validated['biaya_pengiriman'],
            'status' => $validated['status'],
            'subtotal' => $subtotal,
            'total' => $total,
        ]);

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil ditambahkan!');
    }
}
