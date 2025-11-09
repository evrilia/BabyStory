<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Statistic;

class StatisticSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['bulan' => 'Januari', 'produk_terlaris' => 'Tempat Tidur', 'jumlah_transaksi' => 76, 'total_pendapatan' => 18000000],
            ['bulan' => 'Februari', 'produk_terlaris' => 'Mainan', 'jumlah_transaksi' => 33, 'total_pendapatan' => 15000000],
            ['bulan' => 'Maret', 'produk_terlaris' => 'Stroller', 'jumlah_transaksi' => 75, 'total_pendapatan' => 22000000],
            ['bulan' => 'April', 'produk_terlaris' => 'Mainan', 'jumlah_transaksi' => 90, 'total_pendapatan' => 34000000],
            ['bulan' => 'Mei', 'produk_terlaris' => 'Stroller', 'jumlah_transaksi' => 55, 'total_pendapatan' => 30000000],
            ['bulan' => 'Juni', 'produk_terlaris' => 'Tempat Tidur', 'jumlah_transaksi' => 98, 'total_pendapatan' => 38000000],
            ['bulan' => 'Juli', 'produk_terlaris' => 'Stroller', 'jumlah_transaksi' => 102, 'total_pendapatan' => 40000000],
            ['bulan' => 'Agustus', 'produk_terlaris' => 'Mainan', 'jumlah_transaksi' => 75, 'total_pendapatan' => 29000000],
            ['bulan' => 'September', 'produk_terlaris' => 'Tempat Tidur', 'jumlah_transaksi' => 77, 'total_pendapatan' => 37000000],
            ['bulan' => 'Oktober', 'produk_terlaris' => 'Stroller', 'jumlah_transaksi' => 56, 'total_pendapatan' => 28000000],
            ['bulan' => 'November', 'produk_terlaris' => 'Stroller', 'jumlah_transaksi' => 99, 'total_pendapatan' => 35000000],
            ['bulan' => 'Desember', 'produk_terlaris' => 'Mainan', 'jumlah_transaksi' => 100, 'total_pendapatan' => 45000000],
        ];

        foreach ($data as $d) {
            Statistic::create($d);
        }
    }
}
