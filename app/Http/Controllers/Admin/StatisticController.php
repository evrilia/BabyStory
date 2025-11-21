<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatisticController extends Controller
{
    public function index(Request $request)
    {
        // Ambil mode dari URL, default 'bulan'
        $mode = $request->get('mode', 'bulan');

        $statistics = collect([]);
        $labels = [];
        $values = [];

        // ==========================================
        // LOGIKA 1: MODE TAHUNAN
        // ==========================================
        if ($mode === 'tahun') {
            $currentYear = date('Y');
            // Loop 5 tahun terakhir (misal: 2021-2025)
            for ($i = $currentYear - 4; $i <= $currentYear; $i++) {
                $year = $i;

                // Hitung Data
                $orders = Order::whereYear('created_at', $year)
                    ->whereIn('status', ['Selesai', 'Proses', 'Perpanjangan']);

                $totalPendapatan = $orders->sum('total');
                $jumlahTransaksi = $orders->count();

                // Produk Terlaris
                $bestSelling = Order::select('nama_produk', DB::raw('count(*) as total'))
                    ->whereYear('created_at', $year)
                    ->whereIn('status', ['Selesai', 'Proses', 'Perpanjangan'])
                    ->groupBy('nama_produk')
                    ->orderByDesc('total')
                    ->first();

                // Push ke Collection
                $statistics->push((object) [
                    'tahun' => $year,
                    'produk_terlaris' => $bestSelling ? $bestSelling->nama_produk : '-',
                    'jumlah_transaksi' => $jumlahTransaksi,
                    'total_pendapatan' => $totalPendapatan
                ]);

                $labels[] = (string) $year;
                $values[] = $totalPendapatan;
            }

            // ==========================================
            // LOGIKA 2: MODE BULANAN
            // ==========================================
        } else {
            $currentYear = date('Y');

            for ($i = 1; $i <= 12; $i++) {
                // Gunakan createFromDate agar aman
                $date = Carbon::createFromDate($currentYear, $i, 1);
                $monthName = $date->locale('id')->isoFormat('MMMM');

                // Hitung Data
                $orders = Order::whereYear('created_at', $currentYear)
                    ->whereMonth('created_at', $i)
                    ->whereIn('status', ['Selesai', 'Proses', 'Perpanjangan']);

                $totalPendapatan = $orders->sum('total');
                $jumlahTransaksi = $orders->count();

                // Produk Terlaris
                $bestSelling = Order::select('nama_produk', DB::raw('count(*) as total'))
                    ->whereYear('created_at', $currentYear)
                    ->whereMonth('created_at', $i)
                    ->whereIn('status', ['Selesai', 'Proses', 'Perpanjangan'])
                    ->groupBy('nama_produk')
                    ->orderByDesc('total')
                    ->first();

                // Push ke Collection
                $statistics->push((object) [
                    'bulan' => $monthName,
                    'produk_terlaris' => $bestSelling ? $bestSelling->nama_produk : '-',
                    'jumlah_transaksi' => $jumlahTransaksi,
                    'total_pendapatan' => $totalPendapatan
                ]);

                $labels[] = $monthName;
                $values[] = $totalPendapatan;
            }
        }

        // Return View
        return view('pages.admin.statistics', compact('statistics', 'labels', 'values', 'mode'));
    }
}