<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\RentalReminder;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->paginate(10);
        return view('pages.admin.order.orders', compact('orders'));
    }

    public function create()
    {
        // Ambil produk yang stoknya ada
        $products = Product::with('category')->where('stok', '>', 0)->get();
        return view('pages.admin.order.create-orders', compact('products'));
    }

    public function store(Request $request)
    {
        $product = Product::where('nama_produk', $request->nama_produk)->first();

        if (!$product || $product->stok <= 0) {
            return back()->withErrors(['msg' => 'Stok produk habis atau tidak ditemukan!']);
        }

        $validated = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_hp' => 'required|numeric',
            'alamat' => 'required|string',
            'kota_tujuan' => 'required|string',
            'nama_produk' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'biaya_pengiriman' => 'required|numeric',
            'total' => 'required|numeric',
            'ktp' => 'nullable|image|max:5102',
        ]);

        $start = Carbon::parse($request->start_date);
        $end = Carbon::parse($request->end_date);
        $lamaSewaString = ($start->diffInDays($end) + 1) . ' Hari';

        $ktpPath = $request->hasFile('ktp') ? $request->file('ktp')->store('ktp', 'public') : null;
        $subtotal = $request->total - $request->biaya_pengiriman;

        $order = Order::create([
            'nama_pelanggan' => $validated['nama_pelanggan'],
            'email' => $validated['email'],
            'no_hp' => $validated['no_hp'],
            'alamat' => $validated['alamat'],
            'kota_tujuan' => $validated['kota_tujuan'],
            'ktp' => $ktpPath,
            'nama_produk' => $validated['nama_produk'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'lama_sewa' => $lamaSewaString,
            'biaya_pengiriman' => $validated['biaya_pengiriman'],
            'subtotal' => $subtotal,
            'total' => $validated['total'],
            'status' => 'Konfirmasi',
        ]);

        // TRIGGER EMAIL KONFIRMASI
        try {
            $subject = "Konfirmasi Pesanan - Baby Story";
            $content = "Halo {$order->nama_pelanggan},\n\n" .
                "Pesanan Anda untuk produk {$order->nama_produk} telah kami terima.\n" .
                "Status saat ini: {$order->status}.\n\n" .
                "Terima kasih telah mempercayakan kebutuhan bayi Anda kepada kami.";

            Mail::to($order->email)->send(new RentalReminder($subject, $content));
        } catch (\Exception $e) {
            \Log::error("Gagal kirim email konfirmasi: " . $e->getMessage());
        }

        $product->decrement('stok');

        return redirect()->route('admin.orders.index')->with('success', 'Pesanan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $statusLama = $order->status;

        $request->validate([
            'status' => 'required',
            'end_date' => 'required|date',
            'total' => 'required|numeric',
            'lama_sewa' => 'required|string',
        ]);

        $order->update([
            'status' => $request->status,
            'end_date' => $request->end_date,
            'lama_sewa' => $request->lama_sewa,
            'total' => $request->total,
        ]);

        // TRIGGER EMAIL JIKA SELESAI (Gunakan RentalReminder agar konsisten)
        if ($request->status == 'Selesai' && $statusLama != 'Selesai') {
            try {
                $subject = "Pesanan Selesai - Baby Story";
                $content = "Halo {$order->nama_pelanggan},\n\n" .
                    "Pesanan Anda #{$order->id} telah selesai. Terima kasih telah menyewa di Baby Story!";

                Mail::to($order->email)->send(new RentalReminder($subject, $content));
            } catch (\Exception $e) {
                \Log::error("Gagal kirim email status selesai: " . $e->getMessage());
            }
        }

        // Logika Stok
        $statusNonAktif = ['Selesai', 'Batal'];
        if (!in_array($statusLama, $statusNonAktif) && in_array($request->status, $statusNonAktif)) {
            $product = Product::where('nama_produk', $order->nama_produk)->first();
            if ($product) {
                $product->increment('stok');
            }
        }

        return redirect()->route('admin.orders.index')->with('success', 'Pesanan diperbarui!');
    }
}