<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomDesignController;
use Illuminate\Support\Facades\Route;
use App\Livewire\CreateCustomRequest;
use App\Http\Controllers\MyOrders;
use App\Http\Controllers\RevisionController;
use App\Http\Controllers\WorkerTaskController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketMessageController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/products', [ProductController::class, 'index'])->middleware(['auth'])->name('products.index');
Route::get('/products/category/{category}', [ProductController::class, 'category'])->middleware(['auth'])->name('products.category');
Route::post('/cart/add/{id}', [CartController::class, 'create'])->middleware(['auth'])->name('cart.add');


Route::get('/cart', ['App\Http\Controllers\CartController', 'index'])->middleware(['auth'])->name('cart.index');
Route::get('/cart/{id}', ['App\Http\Controllers\CartController', 'create'])->middleware(['auth'])->name('cart.create');
Route::get('/cart/{id}/destroy', ['App\Http\Controllers\CartController', 'destroy'])->middleware(['auth'])->name('cart.destroy');
Route::get('/cart-clear', ['App\Http\Controllers\CartController', 'clear'])->middleware(['auth'])->name('cart.clear');

Route::get('/checkout', ['App\Http\Controllers\CheckoutController', 'index'])->middleware(['auth'])->name('cart.index');
Route::post('/checkout/apply-coupon', ['App\Http\Controllers\CheckoutController', 'applyCoupon'])->middleware(['auth'])->name('cart.applyCoupon');  // Menambahkan kupon ke checkout
Route::get('/checkout/createOrder', ['App\Http\Controllers\CheckoutController', 'createOrder'])->middleware(['auth'])->name('cart.createOrder');
Route::get('/checkout/createInvoice/{id}', ['App\Http\Controllers\CheckoutController', 'createInvoice'])->middleware(['auth'])->name('cart.createInvoice');


// Route untuk halaman pemesanan
Route::get('/order-custom-design', CreateCustomRequest::class)->middleware(['auth'])->name('order.custom');

// my orders
Route::get('/my-orders', [MyOrders::class, 'index'])->middleware(['auth'])->name('myorders.index');
Route::get('/order/{orderId}/progress', [MyOrders::class, 'showProgress'])->middleware(['auth'])->name('myorders.progress');
Route::post('/orders/{order}/reorder', [MyOrders::class, 'reorder'])->middleware(['auth'])->name('orders.reorder');

Route::resource('revisions', RevisionController::class)->only('store');
Route::put('worker-tasks/{id}/complete', [WorkerTaskController::class, 'complete'])->middleware(['auth'])->name('worker-tasks.complete');
// Worker

// FEEDBACK
Route::get('/my-orders/review/{order}', [FeedbackController::class, 'create'])->middleware(['auth'])->name('feedback.create');
Route::post('/my-orders/review/{order}', [FeedbackController::class, 'store'])->middleware(['auth'])->name('feedback.store');

// PROMOS
Route::get('/promos', [PromoController::class, 'index'])->middleware(['auth'])->name('promos.index');
Route::middleware('auth')->group(function () {
//Custom Design
Route::resource('/custom-design', CustomDesignController::class);
Route::post('/custom-design', [CustomDesignController::class, 'store'])->middleware(['auth'])->name('custom-design.store');
Route::post('/checkout/custom-design', [CheckoutController::class, 'createCustomOrder'])->middleware(['auth'])->name('checkout.createCustomOrder');
});
Route::post('/webhook', [WebhookController::class, 'webhook'])->name('webhook');

//Transaction
Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
Route::get('/transactions/pay/{id}', [TransactionController::class, 'pay'])->name('transactions.pay');

Route::get('/transaction/{transaction}/pay', [CheckoutController::class, 'payTransaction'])->name('transaction.pay');

// Invoice
Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
Route::get('/invoices/{invoice}/download', [InvoiceController::class, 'generatePdf'])->name('invoices.download');

//Tickets
Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
Route::post('/ticket-messages', [TicketMessageController::class, 'store'])->name('ticket-messages.store');

Route::get('/login', function () {
    return redirect('/admin/login'); // Redirect ke Filament login
})->name('login');

Route::get('/logout', function () {
    return redirect('/logout'); // Redirect ke Filament login
})->name('logout');

Route::get('/test-mail', function () {
    try {
        Mail::raw('Tes email Laravel', function ($message) {
            $message->to('a.n.caturpamungkas@gmail.com')
                    ->subject('Email Tes');
        });
        return "Email berhasil dikirim!";
    } catch (\Exception $e) {
        return "Gagal mengirim email: " . $e->getMessage();
    }
});

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return redirect('/admin');
})->middleware(['auth', 'signed'])->name('verification.verify');
