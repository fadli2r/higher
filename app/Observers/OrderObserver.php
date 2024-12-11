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

        // Pastikan order sudah selesai (completed)
        if ($order->order_status === 'completed') {
            // Mendapatkan produk yang dipesan dalam order
            $order = Order::with('product.workflows', 'worker')->find($order->id);

            $product = $order->product;
            $category = $product->category;

            $worker = CategoryWorker::where('category_id', $category->id)
                                     ->first()?->worker;

            // Jika pekerja ditemukan, tetapkan pekerja ke order dan buat tugas untuk pekerja
            if ($worker && $worker->user) {
                // Menetapkan pekerja ke order
                $order->worker_id = $worker->id;
                $order->save();  // Simpan perubahan pada order

                // Mendapatkan semua workflows dari produk
                $workflows = ProductWorkflow::where('product_id', $product->id)
                    ->orderBy('step_order') // Pastikan urutan stepnya benar
                    ->get();

                // Menyimpan semua worker tasks berdasarkan workflows produk
                foreach ($workflows as $workflow) {
                    WorkerTask::create([
                        'worker_id' => $worker->id,
                        'order_id' => $order->id,
                        'task_description' => 'Tugas untuk produk: ' . $product->title . ' - Step: ' . $workflow->step_name,
                        'progress' => 'not_started',  // Status awal
                        'deadline' => now()->addDays($workflow->step_duration),  // Deadline berdasarkan durasi step
                        'task_count' => 1,  // Anggap satu task untuk setiap step
                        'product_workflow_id' => $workflow->id,
                    ]);
                }
            }

            // Mendapatkan user yang terkait dengan order
            $this->updateUserMembershipStatus($order->user);


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
