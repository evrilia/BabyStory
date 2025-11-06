<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\YearlyStatistic;

class YearlyStatisticSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['tahun' => 2020, 'produk_terlaris' => 'Tempat Tidur', 'jumlah_transaksi' => 76, 'total_pendapatan' => 750000000],
            ['tahun' => 2021, 'produk_terlaris' => 'Mainan', 'jumlah_transaksi' => 33, 'total_pendapatan' => 1750000000],
            ['tahun' => 2022, 'produk_terlaris' => 'Stroller', 'jumlah_transaksi' => 75, 'total_pendapatan' => 1900000000],
            ['tahun' => 2023, 'produk_terlaris' => 'Mainan', 'jumlah_transaksi' => 90, 'total_pendapatan' => 1250000000],
            ['tahun' => 2024, 'produk_terlaris' => 'Stroller', 'jumlah_transaksi' => 95, 'total_pendapatan' => 2400000000],
        ];

        foreach ($data as $d) {
            YearlyStatistic::create($d);
        }
    }
}
