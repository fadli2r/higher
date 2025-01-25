<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Mail\Visualbuilder\EmailTemplates\{PembayaranBerhasil, WorkerNewOrder};
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function webhook(Request $request)
    {
        // Validasi payload
        $data = $request->all();

        if (str_contains($data['description'], '[PELUNASAN]')) {
            $transaction = Transaction::where('invoice_id_full_paid', $data['id'])->update([
                'remaining_payment' => 0,
                'down_payment' => 0
            ]);
            
            return;
        }

        // Temukan transaksi berdasarkan invoice_id dari payload
        $transaction = Transaction::where('invoice_id', $data['id'])->with('orders.product', 'orders.worker.user', 'user')->first();

        $temp_transaction = $transaction;

        // return response()->json($temp_transaction);

        // foreach ($temp_transaction->orders as $order) {
        //     $order->created_at = Carbon::create($order->created_at)->isoFormat('LLL');
        //     // return new WorkerNewOrder($order);
        //     Mail::to($order->worker->user->email)->send(new WorkerNewOrder($order));
        // }

        if (!$transaction) {
            return response()->json(['status' => 'failed', 'message' => 'Transaction not found'], 404);
        }

        // Perbarui status transaksi berdasarkan payload
        if ($data['status'] === 'PAID') {
            $transaction->update([
                'payment_status' => 'paid',
            ]);

            // // Perbarui semua order yang terkait dengan transaksi ini
            // $transaction->orders()->update([
            //     'order_status' => 'in_progress',
            //     'updated_at' => now(),
            // ]);

        } elseif ($data['status'] === 'FAILED') {
            $transaction->update([
                'payment_status' => 'failed',
            ]);

            // Jika pembayaran gagal, Anda dapat mengambil tindakan tambahan di sini
        }

        try {            
            $temp_transaction->external_id = $data['external_id'];
            $temp_transaction->paid_at = Carbon::create($data['paid_at'])->isoFormat('LLL');
            $temp_transaction->payment_method = $data['payment_method'];
            $temp_transaction->paid_amount = 'Rp ' . number_format($data['paid_amount'], 2, ',', '.');;

            $order = array_map(function($item) {
                return $item['product']['title'];
            }, $temp_transaction->orders->toArray());

            $temp_transaction['detail_order'] = implode(', ', $order);;

            Mail::to($temp_transaction->user->email)->send(new PembayaranBerhasil($temp_transaction));
        } catch (\Throwable $th) {
            throw $th;
        }


        // return response()->json(['status' => 'success'], 200);
    }
}
