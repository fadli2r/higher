<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\WorkerTask;
use App\Models\Revision;
use Illuminate\Http\Request;

class MyOrders extends Controller
{
    public function index(Request $request)
    {
        // Query pesanan milik user yang sedang login
        $query = Order::where('user_id', auth()->id())
            ->with('workerTasks.productWorkflow');

        // Tambahkan filter berdasarkan status jika parameter `status` diberikan
        if ($request->has('status') && in_array($request->status, ['pending', 'in_progress', 'completed', 'cancelled'])) {
            $query->where('order_status', $request->status);
        }

        // Ambil data pesanan dengan filter yang diterapkan
        $orders = $query->get();

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
