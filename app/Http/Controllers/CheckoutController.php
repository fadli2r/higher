<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Xendit\Xendit;
use App\Models\{Order, Transaction};

class CheckoutController extends Controller
{
    function index() {
        $cart = Cart::where('user_id', auth()->id())->with('product')->get();

        return view('checkout.index', ['cart' => $cart]);
    }

    function createOrder() {
        $cart = Cart::where('user_id', auth()->id())->with('product')->get();

        foreach ($cart as $item) {
            Order::create([
                'user_id' => auth()->id(),
                'product_id' => $item->product_id,
                // 'worker_id' => $item->product->worker_id,
                'total_price' => $item->product->price,
                'order_status' => 'pending',
            ]);
        }

        Cart::where('user_id', auth()->id())->delete();
        flash()->success('Berhasil membuat order, silahkan bayar sekarang');
        return redirect()->to('/admin/orders');
    }

    function createInvoice($id) {
            // Set API Key
        Xendit::setApiKey(env('XENDIT_SECRET_KEY'));
        $order = Order::find($id);

        // Parameter invoice
        $params = [
            'external_id' => 'invoice-' . time(),
            'payer_email' => auth()->user()->email,
            'description' => "Pembelian Jasa Layanan ".$order->product->title,
            'amount' => $order->total_price,
        ];

        try {
            $invoice = \Xendit\Invoice::create($params);

            $transaction = Transaction::create([
                'order_id' => $order->id,
                'payment_status' => 'pending',
                'invoice_url' => $invoice['invoice_url'],
                'invoice_number' => $invoice['external_id'],
                'invoice_id' => $invoice['id'],
            ]);

            return redirect()->to($invoice['invoice_url']);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
