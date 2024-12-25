<?php

namespace App\Console;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\Subscriptions;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Daftar command yang tersedia.
     */
    protected $commands = [
        // Tambahkan command Anda di sini jika ada
    ];

    /**
     * Daftar perintah yang akan dijalankan berdasarkan jadwal.
     */
    protected function schedule(Schedule $schedule)
{
    $schedule->call(function () {
        $subscriptions = Subscriptions::where('status', 'active')
            ->where('end_date', '<=', now()->addDays(7)) // Langganan akan habis dalam 7 hari
            ->get();

        foreach ($subscriptions as $subscription) {
            // Buat invoice baru untuk perpanjangan
            $invoice = Invoice::create([
                'user_id' => $subscription->user_id,
                'subscription_id' => $subscription->id,
                'total_price' => $subscription->product->subscription_price,
                'status' => 'pending',
            ]);

            // Kirim notifikasi email
            //Notification::send($subscription->user, new SubscriptionRenewalNotification($invoice));
        }
    })->daily(); // Jalankan setiap hari
}

public function createSubscription($userId, $productId, $interval)
{
    $startDate = now();
    $endDate = $interval === 'monthly' ? $startDate->addMonth() : $startDate->addYear();

    return Subscriptions::create([
        'user_id' => $userId,
        'product_id' => $productId,
        'start_date' => $startDate,
        'end_date' => $endDate,
        'status' => 'active',
    ]);
}

public function renewSubscriptions()
{
    $subscriptions = Subscriptions::where('status', 'active')
        ->where('end_date', '<', now())
        ->get();

    foreach ($subscriptions as $subscription) {
        $interval = $subscription->product->subscription_interval;
        $this->createSubscription($subscription->user_id, $subscription->product_id, $interval);
        // Optionally create an invoice here
    }
}
public function expireSubscriptions()
{
    Subscriptions::where('status', 'active')
        ->where('end_date', '<', now())
        ->update(['status' => 'expired']);
}




    /**
     * Daftar perintah untuk dijalankan di CLI.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
    }
}
