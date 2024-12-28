<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Product, Cart, Category};

class ProductController extends Controller
{
    function index() {
        $cart = Cart::where('user_id', auth()->id())->with('product')->get();
        $categories = Category::all();
        return view('products.index', compact('categories'));
    }
    public function category(Category $category)
    {
        $products = Product::where('category_id', $category->id)->get();
        return view('products.category', compact('products', 'category'));
    }

    function show($id){
        $product = Product::findOrFail($id);
        return view('products.show', ['product' => $product]);
    }
}
