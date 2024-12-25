<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\Worker;
use App\Models\WorkerTask;
use App\Models\ProductWorkflow;
use App\Models\User;
use App\Models\CategoryWorker;  // Model CategoryWorker
use App\Jobs\CreateWorkerTask;

use App\Models\Pekerja;  // Model pekerja (pekerjas)

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {

    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
{
    // Pastikan status order adalah "in_progress"
    if ($order->order_status === 'in_progress') {
        // Ambil data lengkap order dengan relasi yang diperlukan
        $order = Order::with(['product.workflows', 'product.category', 'worker'])->find($order->id);

        if (!$order || !$order->product) {
            return; // Jika tidak ada produk terkait, hentikan proses
        }

        $product = $order->product;

        // Ambil pekerja berdasarkan kategori produk
        $worker = CategoryWorker::where('category_id', $product->category->id ?? null)
                                ->first()?->worker;

        if ($worker) {
            // Update worker_id pada order jika belum ada
            if (!$order->worker_id) {
                $order->worker_id = $worker->id;
                $order->save();
            }

            // Tambahkan workflows ke tabel worker_tasks jika belum ada
            $this->assignWorkflowsToWorker($order, $worker);
        }
        $this->updateUserMembershipStatus($order->user);

    }
}

private function assignWorkflowsToWorker(Order $order, $worker)
{
    $existingTaskIds = WorkerTask::where('order_id', $order->id)
        ->pluck('product_workflow_id')
        ->toArray();

    $workflows = ProductWorkflow::where('product_id', $order->product_id)
        ->whereNotIn('id', $existingTaskIds) // Hindari workflow yang sudah ada
        ->orderBy('step_order')
        ->get();

    $lastDeadline = now();

    foreach ($workflows as $workflow) {
        $lastDeadline = $lastDeadline->addDays($workflow->step_duration);

        WorkerTask::create([
            'worker_id' => $worker->id,
            'order_id' => $order->id,
            'task_description' => 'Tugas untuk produk: ' . $order->product->title . ' - Step: ' . $workflow->step_name,
            'progress' => 'not_started',
            'deadline' => $lastDeadline,
            'task_count' => 1,
            'product_workflow_id' => $workflow->id,
        ]);
    }
}


    protected function updateUserMembershipStatus($user)
    {
        // Menghitung total pembelian dari order yang telah selesai
        $totalSpent = $user->orders()->where('order_status', 'completed')->sum('total_price');

        // Jika total lebih dari 1 juta dan status belum 'member', ubah status menjadi 'member'
        if ($totalSpent >= 1000000 && $user->membership_status !== 'member') {
            $user->membership_status = 'member';
            $user->save();  // Simpan perubahan pada user
        }
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        //
    }
}
