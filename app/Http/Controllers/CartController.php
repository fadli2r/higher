<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cart = Cart::where('user_id', auth()->id())->with('product')->get();

        return view('checkout.index', ['cart' => $cart]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
{
    // Cek apakah user sudah login
    if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
    }

    // Cek apakah produk sudah ada di keranjang
    $cart = Cart::where('user_id', auth()->id())
        ->where('product_id', $id)
        ->first();

    if ($cart) {
        return redirect()->route('cart.index')->with('warning', 'Produk ini sudah ada di keranjang.');
    }

    // Tambahkan produk ke keranjang
    Cart::create([
        'user_id' => auth()->id(),
        'product_id' => $id,
        'quantity' => 1,
    ]);

    // Redirect langsung ke halaman checkout
    return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $cart = Cart::find($id)->delete();
        flash()->success('Berhasil menghapus produk dari keranjang');

        return redirect()->route('cart.index');
    }

    public function clear()
    {
        $cart = Cart::where('user_id', auth()->id())->delete();
        flash()->success('Berhasil menghapus semua produk dari keranjang');
        return redirect()->route('products.index');
    }
}
