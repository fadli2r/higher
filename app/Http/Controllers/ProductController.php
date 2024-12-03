<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Product, Cart};

class ProductController extends Controller
{
    function index() {
        $cart = Cart::where('user_id', auth()->id())->with('product')->get();
        $products = Product::all();
        return view('products.index', ['products' => $products, 'cart' => $cart]);
    }

    function show($id){
        $product = Product::findOrFail($id);
        return view('products.show', ['product' => $product]);
    }
}
