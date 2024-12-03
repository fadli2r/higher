<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/products', ['App\Http\Controllers\ProductController', 'index'])->name('products.index');
Route::get('/products/{id}', ['App\Http\Controllers\ProductController', 'show'])->name('products.show');

Route::get('/cart', ['App\Http\Controllers\CartController', 'index'])->name('cart.index');
Route::get('/cart/{id}', ['App\Http\Controllers\CartController', 'create'])->name('cart.create');
Route::get('/cart-clear', ['App\Http\Controllers\CartController', 'clear'])->name('cart.clear');

Route::get('/checkout', ['App\Http\Controllers\CheckoutController', 'index'])->name('cart.index');
