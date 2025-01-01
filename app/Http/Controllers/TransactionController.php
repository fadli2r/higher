<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Transaction;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
{
    // Proses overdue invoices
    $overdueInvoices = Invoice::whereHas('transaction', function ($query) {
        $query->where('user_id', auth()->id());
    })
    ->where('status', 'pending')
    ->where('due_date', '<', now())
    ->latest()
    ->get();

    foreach ($overdueInvoices as $invoice) {
        $invoice->update(['status' => 'cancelled']);

        $transaction = $invoice->transaction;
        if ($transaction) {
            $transaction->update(['payment_status' => 'failed']);

            foreach ($transaction->orders as $order) {
                $order->update(['order_status' => 'cancelled']);
            }
        }
    }

    // Ambil transaksi berdasarkan status
    $query = Transaction::where('user_id', auth()->id())->with('invoice');

    // Tambahkan filter status
    if ($request->has('status') && in_array($request->status, ['paid', 'pending', 'failed'])) {
        $query->where('payment_status', $request->status);
    }

    $transactions = $query->latest()->get();

    return view('transactions.index', compact('transactions'));
}


    public function pay(Transaction $transaction)
    {
        // Validasi apakah transaksi milik user yang sedang login
        if ($transaction->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Redirect ke URL pembayaran
        return redirect()->to($transaction->invoice_url);
    }
}
