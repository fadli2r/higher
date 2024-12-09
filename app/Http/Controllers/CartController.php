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
        if (auth()->id() == null) {
            return redirect()->route('login');
        }

        $cart = Cart::firstOrCreate([
            'user_id' => auth()->id(),
            'product_id' => $id,
            'quantity' => 1
        ]);

        if ($cart->wasRecentlyCreated) {
            flash()->success('Berhasil menambahkan produk ke keranjang');
            return redirect()->route('products.index');
        }

        if ($cart->exists) {
            flash()->warning('Hanya bisa menambahkan produk yang sama sekali');
            return redirect()->route('products.index');
        }
        
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
