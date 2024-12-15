<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\WorkerTask;
use App\Models\Revision;
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

    public function storeRevision(Request $request, WorkerTask $task)
    {
        $request->validate([
            'description' => 'required|string|max:1000',
        ]);

        Revision::create([
            'task_id' => $task->id,
            'requested_by' => auth()->id(),
            'description' => $request->description,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Permintaan revisi berhasil dikirim.');
    }
}
