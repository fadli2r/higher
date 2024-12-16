<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Coupon;

use Xendit\Xendit;
use App\Models\{Order, Transaction};

class CheckoutController extends Controller
{
    function index() {
        $cart = Cart::where('user_id', auth()->id())->with('product')->get();

        return view('checkout.index', ['cart' => $cart]);
    }

    public function applyCoupon(Request $request)
    {
        // Validasi kode kupon
        $coupon = Coupon::where('code', $request->coupon_code)->first();

        if ($coupon && $coupon->expires_at > now() && $coupon->is_active) {
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

            // Simpan diskon di session
            session(['coupon_code' => $request->coupon_code]);
            session(['discount' => $discount]);

            return redirect()->route('cart.index')->with('success', 'Coupon applied successfully!');
        } else {
            return redirect()->route('cart.index')->withErrors('Invalid or expired coupon code.');
        }
    }

    function createOrder() {
        $cart = Cart::where('user_id', auth()->id())->with('product')->get();

        $discount = session('discount', 0);
        $totalPriceAfterDiscount = $cart->sum(function ($item) {
            return ($item->product_id ? $item->product->price : $item->customRequest->price) * $item->quantity;
        }) - $discount;

        foreach ($cart as $item) {
            if ($item->product_id) {
                // Proses Produk Biasa
                Order::create([
                    'user_id' => auth()->id(),
                    'product_id' => $item->product_id,
                    'total_price' => $item->product->price * $item->quantity,
                    'order_status' => 'pending',
                ]);
            } elseif ($item->custom_request_id) {
                // Proses Custom Desain
                Order::create([
                    'user_id' => auth()->id(),
                    'custom_request_id' => $item->custom_request_id,
                    'total_price' => $item->customRequest->price * $item->quantity,
                    'order_status' => 'pending',
                ]);
            }
        }

        Cart::where('user_id', auth()->id())->delete();
        flash()->success('Berhasil membuat order, silahkan bayar sekarang');
        return redirect()->to('/admin/orders');
    }

    public function createCustomOrder() {
        $cart = Cart::where('user_id', auth()->id())->whereNotNull('custom_request_id')->with('customRequest')->get();

        foreach ($cart as $item) {
            Order::create([
                'user_id' => auth()->id(),
                'custom_request_id' => $item->custom_request_id,
                'total_price' => $item->customRequest->price * $item->quantity,
                'order_status' => 'pending',
            ]);
        }

        Cart::where('user_id', auth()->id())->whereNotNull('custom_request_id')->delete();

        flash()->success('Berhasil membuat order desain kustom, silahkan bayar sekarang');
        return redirect()->route('orders.index');
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
