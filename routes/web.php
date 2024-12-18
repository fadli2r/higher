<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomDesignController;
use Illuminate\Support\Facades\Route;
use App\Livewire\CreateCustomRequest;
use App\Http\Controllers\MyOrders;
use App\Http\Controllers\RevisionController;
use App\Http\Controllers\WorkerTaskController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\WebhookController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/products', ['App\Http\Controllers\ProductController', 'index'])->name('products.index');
Route::get('/products/{id}', ['App\Http\Controllers\ProductController', 'show'])->name('products.show');

Route::get('/cart', ['App\Http\Controllers\CartController', 'index'])->name('cart.index');
Route::get('/cart/{id}', ['App\Http\Controllers\CartController', 'create'])->name('cart.create');
Route::get('/cart/{id}/destroy', ['App\Http\Controllers\CartController', 'destroy'])->name('cart.destroy');
Route::get('/cart-clear', ['App\Http\Controllers\CartController', 'clear'])->name('cart.clear');

Route::get('/checkout', ['App\Http\Controllers\CheckoutController', 'index'])->name('cart.index');
Route::post('/checkout/apply-coupon', ['App\Http\Controllers\CheckoutController', 'applyCoupon'])->name('cart.applyCoupon');  // Menambahkan kupon ke checkout
Route::get('/checkout/createOrder', ['App\Http\Controllers\CheckoutController', 'createOrder'])->name('cart.createOrder');
Route::get('/checkout/createInvoice/{id}', ['App\Http\Controllers\CheckoutController', 'createInvoice'])->name('cart.createInvoice');


// Route untuk halaman pemesanan
Route::get('/order-custom-design', CreateCustomRequest::class)->name('order.custom');

// my orders
Route::get('/my-orders', [MyOrders::class, 'index'])->name('myorders.index');
Route::get('/order/{orderId}/progress', [MyOrders::class, 'showProgress'])->name('myorders.progress');

Route::resource('revisions', RevisionController::class)->only('store');
Route::put('worker-tasks/{id}/complete', [WorkerTaskController::class, 'complete'])->name('worker-tasks.complete');
// Worker

// FEEDBACK
Route::get('/my-orders/review/{order}', [FeedbackController::class, 'create'])->name('feedback.create');
Route::post('/my-orders/review/{order}', [FeedbackController::class, 'store'])->name('feedback.store');

// PROMOS
Route::get('/promos', [PromoController::class, 'index'])->name('promos.index');

//Custom Design
Route::resource('/custom-design', CustomDesignController::class);
Route::post('/checkout/custom-design', [CheckoutController::class, 'createCustomOrder'])->name('checkout.createCustomOrder');

Route::post('/webhook', [WebhookController::class, 'webhook'])->name('webhook');
