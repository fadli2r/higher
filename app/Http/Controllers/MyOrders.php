<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\WorkerTask;
use Illuminate\Http\Request;

class MyOrders extends Controller
{
    public function index()
    {
        // Ambil pesanan yang dimiliki oleh user yang sedang login
        $orders = Order::where('user_id', auth()->id())->with('workerTasks.productWorkflow')->get();

        // Kirim data pesanan ke view
        return view('myorders.index', compact('orders'));
    }

    public function showProgress($orderId)
    {
        // Tampilkan halaman progress untuk order tertentu
        $order = Order::with('workerTasks.productWorkflow')->findOrFail($orderId);

        return view('myorders.progress', compact('order'));
    }
}
