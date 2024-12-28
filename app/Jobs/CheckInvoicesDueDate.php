<?php

namespace App\Jobs;

use App\Models\Invoice;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class CheckInvoicesDueDate implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function handle()
    {
        // Ambil invoice yang belum selesai dan telah melewati due_date
        $overdueInvoices = Invoice::where('status', 'pending')
            ->where('due_date', '<', now())
            ->get();

        foreach ($overdueInvoices as $invoice) {
            // Update status invoice
            $invoice->update(['status' => 'canceled']);

            // Update status transaksi terkait
            $transaction = $invoice->transaction;
            if ($transaction) {
                $transaction->update(['payment_status' => 'canceled']);
            }

            // Update status order terkait
            if ($transaction && $transaction->orders) {
                foreach ($transaction->orders as $order) {
                    $order->update(['order_status' => 'canceled']);
                }
            }

            // Log aktivitas
            Log::info("Invoice ID {$invoice->id} and related transactions/orders have been canceled.");
        }
    }
}
