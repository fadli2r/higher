<?php

namespace App\Observers;

use App\Models\Transaction;

class TransactionObserver
{
    /**
     * Handle the Transaction "created" event.
     */
    public function created(Transaction $transaction): void
    {
        //
    }

    /**
     * Handle the Transaction "updated" event.
     */
    public function updated(Transaction $transaction)
{
    // Periksa apakah payment_status berubah dan sekarang bernilai 'paid'
    if ($transaction->wasChanged('payment_status') && $transaction->payment_status === 'paid') {
        // Perbarui semua pesanan terkait dengan transaksi
        $orders = $transaction->orders;

        foreach ($orders as $order) {
            $order->update([
                'order_status' => 'in_progress',
            ]);
        }

        // Perbarui invoice terkait dengan transaksi
        $invoice = $transaction->invoice;
        if ($invoice) {
            $invoice->update([
                'status' => 'paid',
            ]);
        }
    }

    // Jika payment_status berubah menjadi 'failed', perbarui invoice dan orders
    if ($transaction->wasChanged('payment_status') && $transaction->payment_status === 'failed') {
        // Perbarui semua pesanan terkait menjadi 'cancelled'
        $orders = $transaction->orders;

        foreach ($orders as $order) {
            $order->update([
                'order_status' => 'cancelled',
            ]);
        }

        // Perbarui invoice terkait menjadi 'failed'
        $invoice = $transaction->invoice;
        if ($invoice) {
            $invoice->update([
                'status' => 'cancelled',
            ]);
        }
    }
}


    /**
     * Handle the Transaction "deleted" event.
     */
    public function deleted(Transaction $transaction): void
    {
        //
    }

    /**
     * Handle the Transaction "restored" event.
     */
    public function restored(Transaction $transaction): void
    {
        //
    }

    /**
     * Handle the Transaction "force deleted" event.
     */
    public function forceDeleted(Transaction $transaction): void
    {
        //
    }
}
