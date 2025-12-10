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
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim reminder sewa via Email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai proses reminder email...');

        $subject = Setting::where('key', 'email_subject')->value('value') ?? 'Reminder Sewa';

        $dates = [
            'H-3' => Carbon::now()->addDays(3)->format('Y-m-d'),
            'H-2' => Carbon::now()->addDays(2)->format('Y-m-d'),
            'H-1' => Carbon::now()->addDays(1)->format('Y-m-d'),
        ];

        foreach ($dates as $label => $dateTarget) {
            $templateKey = 'msg_' . strtolower(str_replace('-', '', $label));
            $templateRaw = Setting::where('key', $templateKey)->value('value');

            if (!$templateRaw) continue;

            $orders = Order::whereDate('end_date', $dateTarget)
                           ->whereNotNull('email')
                           ->where('email', '!=', '')
                           ->whereIn('status', ['Proses', 'Perpanjangan', 'Konfirmasi'])
                           ->get();

            foreach ($orders as $order) {
                $messageBody = str_replace(
                    ['{nama}', '{produk}', '{tanggal}'],
                    [$order->nama_pelanggan, $order->nama_produk, Carbon::parse($order->end_date)->format('d M Y')],
                    $templateRaw
                );

                try {
                    Mail::to($order->email)->send(new RentalReminder($subject . " ($label)", $messageBody));
                    $this->info("Sukses kirim email ke: {$order->email}");
                } catch (\Exception $e) {
                    $this->error("Gagal kirim ke {$order->email}: " . $e->getMessage());
                }
            }
        }
    }
}