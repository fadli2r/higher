<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Cart, Coupon, Invoice, Order, Subscriptions, Transaction};
use Xendit\Xendit;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Cart::where('user_id', auth()->id())->with('product')->get();

        return view('checkout.index', ['cart' => $cart]);
    }

    public function applyCoupon(Request $request)
{
    // Cari kupon berdasarkan kode
    $coupon = Coupon::where('code', $request->coupon_code)->first();

    if (!$coupon) {
        // Kupon tidak ditemukan
        return redirect()->route('cart.index')->withErrors('Coupon code does not exist.');
    }

    if ($coupon->expires_at <= now()) {
        // Kupon sudah kedaluwarsa
        return redirect()->route('cart.index')->withErrors('This coupon has expired.');
    }

    if (!$coupon->is_active) {
        // Kupon tidak aktif
        return redirect()->route('cart.index')->withErrors('This coupon is not active.');
    }

    // Hitung diskon
    $discount = 0;
    $cartTotal = Cart::where('user_id', auth()->id())->get()->sum(function ($item) {
        return $item->product->price * $item->quantity;
    });

    if ($coupon->discount_type === 'fixed') {
        $discount = $coupon->discount_value;
    } elseif ($coupon->discount_type === 'percentage') {
        $discount = ($coupon->discount_value / 100) * $cartTotal;
    }

    // Simpan kupon dan diskon ke sesi
    session(['coupon_code' => $request->coupon_code]);
    session(['discount' => $discount]);

    return redirect()->route('cart.index')->with('success', 'Coupon applied successfully!');
}


    public function createOrder()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $cart = Cart::where('user_id', auth()->id())->with(['product', 'customRequest'])->get();

        if ($cart->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        $discount = session('discount', 0);
        $totalPrice = 0;

        $orders = [];
        $subscriptions = [];

        foreach ($cart as $item) {
            if ($item->product_id) {
                if ($item->product->is_subscription) {
                    $period = request()->input("subscription_period.{$item->id}", 'monthly');
                    $price = $item->product->calculateSubscriptionPrice($period);

                    $subscriptions[] = [
                        'user_id' => auth()->id(),
                        'product_id' => $item->product_id,
                        'start_date' => now(),
                        'end_date' => $period === 'monthly' ? now()->addMonth() : now()->addYear(),
                        'status' => 'pending',
                        'price' => $price,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                } else {
                    $price = $item->product->price * $item->quantity;
                    $orders[] = [
                        'user_id' => auth()->id(),
                        'product_id' => $item->product_id,
                        'total_price' => $price,
                        'order_status' => 'pending',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            } elseif ($item->custom_request_id) {
                $price = $item->customRequest->price * $item->quantity;
                $orders[] = [
                    'user_id' => auth()->id(),
                    'custom_request_id' => $item->custom_request_id,
                    'total_price' => $price,
                    'order_status' => 'pending',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            $totalPrice += $price;
        }

        $totalPriceAfterDiscount = $totalPrice - $discount;

        // Buat transaksi
        $transaction = Transaction::create([
            'user_id' => auth()->id(),
            'total_price' => $totalPriceAfterDiscount,
            'payment_status' => 'pending',

        ]);


        // Simpan orders
        foreach ($orders as &$order) {
            $order['transaction_id'] = $transaction->id;
        }
        Order::insert($orders);

        // Simpan subscriptions
        foreach ($subscriptions as &$subscription) {
            $subscription['transaction_id'] = $transaction->id;
        }
        Subscriptions::insert($subscriptions);

        // Buat invoice
        Invoice::create([
            'invoice_number' => 'INV-' . strtoupper(uniqid()),
            'transaction_id' => $transaction->id,
            'user_id' => auth()->id(),
            'status' => 'pending',
            'total_amount' => $totalPriceAfterDiscount,
            'due_date' => now()->addDays(7),
            'issued_date' => now(),
            'currency' => 'IDR',
            'notes' => 'Terima kasih telah melakukan pembelian.',
        ]);

        Cart::where('user_id', auth()->id())->delete();

        flash()->success('Berhasil membuat order, silahkan lanjutkan pembayaran.');
        return redirect()->route('transaction.pay', ['transaction' => $transaction->id]);
    }

    public function payTransaction($transactionId)
    {
        Xendit::setApiKey(env('XENDIT_SECRET_KEY'));

        $transaction = Transaction::findOrFail($transactionId);


        $params = [
            'external_id' => 'transaction-' . $transaction->id,
            'payer_email' => auth()->user()->email,
            'description' => 'Pembayaran untuk transaksi #' . $transaction->id,
            'amount' => $transaction->total_price,
        ];

        $invoice = \Xendit\Invoice::create($params);

        $transaction->update([
            'invoice_url' => $invoice['invoice_url'],
            'invoice_id' => $invoice['id'],
        ]);

        return redirect()->to($invoice['invoice_url']);
    }
}
