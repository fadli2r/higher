<?php

namespace App\Http\Controllers;
use App\Models\Transaction;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
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
