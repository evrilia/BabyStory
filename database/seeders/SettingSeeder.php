<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'key' => 'email_subject', 
                'value' => 'Peringatan Masa Sewa - Baby Story'
            ],

            [
                'key' => 'msg_h3',
                'value' => "Halo {nama},\n\nKami ingin mengingatkan bahwa masa sewa untuk produk **{produk}** akan berakhir dalam **3 hari lagi** (pada tanggal {tanggal}).\n\nMohon persiapkan produk untuk pengembalian atau hubungi admin jika ingin memperpanjang sewa.\n\nTerima kasih,\nBaby Story"
            ],

            [
                'key' => 'msg_h2',
                'value' => "Halo {nama},\n\nMengingatkan kembali, masa sewa **{produk}** tinggal **2 hari lagi** hingga tanggal {tanggal}.\n\nPastikan kelengkapan produk sudah siap ya.\n\nSalam,\nBaby Story"
            ],

            [
                'key' => 'msg_h1',
                'value' => "⚠️ **PENTING: H-1 PENGEMBALIAN**\n\nHalo {nama},\n\nBesok ({tanggal}) adalah hari terakhir masa sewa **{produk}**.\n\nTim kami akan menghubungi Anda besok untuk konfirmasi jadwal penjemputan/pengembalian. Mohon pastikan produk dalam kondisi baik.\n\nTerima kasih telah menyewa di Baby Story!"
            ],
        ];

        foreach ($data as $item) {
            Setting::updateOrCreate(
                ['key' => $item['key']],
                ['value' => $item['value']]
            );
        }
    }
}