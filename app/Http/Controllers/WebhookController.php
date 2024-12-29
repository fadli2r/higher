<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Mail\Visualbuilder\EmailTemplates\PembayranBerhasil;
use Illuminate\Support\Facades\Mail;

class WebhookController extends Controller
{
    public function webhook(Request $request)
    {
        // Validasi payload
        $data = $request->all();

        // Temukan transaksi berdasarkan invoice_id dari payload
        $transaction = Transaction::where('invoice_id', $data['id'])->first();

        if (!$transaction) {
            return response()->json(['status' => 'failed', 'message' => 'Transaction not found'], 404);
        }

        // Perbarui status transaksi berdasarkan payload
        if ($data['status'] === 'PAID') {
            $transaction->update([
                'payment_status' => 'paid',
            ]);

            // Perbarui semua order yang terkait dengan transaksi ini
            $transaction->orders()->update([
                'order_status' => 'in_progress',
                'updated_at' => now(),
            ]);

        } elseif ($data['status'] === 'FAILED') {
            $transaction->update([
                'payment_status' => 'failed',
            ]);

            // Jika pembayaran gagal, Anda dapat mengambil tindakan tambahan di sini
        }

        Mail::to('a.n.caturpamungkas@gmail.com')->send(new PembayranBerhasil($transaction));

        return response()->json(['status' => 'success'], 200);
    }
}
