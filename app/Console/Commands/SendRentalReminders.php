<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\RentalReminder;

class SendRentalReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:email';

    /**
     * Deskripsi perintah.
     */
    protected $description = 'Kirim reminder sewa otomatis H-3, H-2, H-1, dan Hari H via Email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Ambil data settings untuk template pesan dinamis 
        $settings = Setting::pluck('value', 'key');
        $today = Carbon::today();

        // Loop untuk mengecek Hari H (0) sampai H-3 (3)
        foreach ([0, 1, 2, 3] as $days) {
            $targetDate = $today->copy()->addDays($days);

            // Cari order yang end_date-nya cocok dan statusnya masih aktif
            $orders = Order::whereDate('end_date', $targetDate)
                ->whereNotIn('status', ['Selesai', 'Batal'])
                ->get();

            foreach ($orders as $order) {
                // Tentukan Label dan Key untuk mengambil template dari settings
                $label = ($days == 0) ? "HARI INI" : "H-$days";
                $settingKey = ($days == 0) ? 'msg_h0' : "msg_h$days";

                // Gunakan pesan dari database jika ada, jika tidak gunakan default 
                $rawContent = $settings[$settingKey] ?? "Halo {nama},\n\nIni adalah pengingat bahwa masa sewa produk: {produk} akan berakhir pada {tanggal} ($label).\n\nMohon persiapkan unit untuk dikembalikan.";

                // Ganti variabel dinamis {nama}, {produk}, {tanggal}
                $content = str_replace(
                    ['{nama}', '{produk}', '{tanggal}'],
                    [$order->nama_pelanggan, $order->nama_produk, Carbon::parse($order->end_date)->format('d M Y')],
                    $rawContent
                );

                $subject = "Pengingat Pengembalian Sewa ($label) - #{$order->id}";

                try {
                    // Kirim Email menggunakan Mailable RentalReminder
                    Mail::to($order->email)->send(new RentalReminder($subject, $content));
                    $this->info("Email $label berhasil dikirim ke: {$order->email}");
                } catch (\Exception $e) {
                    $this->error("Gagal kirim ke {$order->email}: " . $e->getMessage());
                }
            }
        }

        $this->info('Proses pengiriman reminder selesai.');
    }
}