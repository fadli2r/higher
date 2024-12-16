<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;


class WebhookController extends Controller
{
    public function webhook(Request $request)
    {
        // Validasi signature atau data sesuai dokumentasi Xendit
        $data = $request->all();

        $transaction = Transaction::where('invoice_id', $data['id'])->first();
        
        if (!$transaction) {
            return response()->json(['status' => 'failed'], 404);
        }

        $transaction->update([
            'payment_status' => "paid",
            'updated_at' => now()
        ]);

        $transaction->order->update([
            'order_status' => "in_progress",
            'updated_at' => now()
        ]);

        // Berikan response 200 OK
        return response()->json(['status' => 'success'], 200);
    }
}
