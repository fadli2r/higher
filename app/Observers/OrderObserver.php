<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\Worker;
use App\Models\WorkerTask;
use App\Models\ProductWorkflow;
use App\Models\User;
use App\Models\CategoryWorker;  // Model CategoryWorker
use App\Jobs\CreateWorkerTask;
use App\Mail\Visualbuilder\EmailTemplates\WorkerNewOrder;
use App\Models\CustomRequest;
use App\Models\Pekerja;  // Model pekerja (pekerjas)
use Illuminate\Support\Facades\Mail;

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
        if ($order->order_status === 'in_progress' && $order->getOriginal('order_status') !== 'in_progress') {
            if ($order->custom_request_id) {
                $this->handleCustomRequestWorkflow($order);
            } else if ($order->product_id) {
                $this->handleProductWorkflow($order);
            }
        }
        if ($order->isDirty('order_status') && $order->order_status === 'completed') {
            $this->updateUserMembershipStatus($order->user);
        }
    }

    private function handleCustomRequestWorkflow(Order $order): void
    {
        $customRequest = CustomRequest::find($order->custom_request_id);

        if (!$customRequest) {
            logger('CustomRequest not found for Order ID: ' . $order->id);
            return;
        }

        // Ambil semua pekerja dalam kategori "Desain"
        $categoryWorkers = CategoryWorker::whereHas('category', function ($query) {
            $query->where('name', 'like', '%Desain%');
        })->with('worker.user')->get();

        // Cari pekerja yang memiliki kurang dari 5 tugas "progress"
        $worker = $categoryWorkers
            ->sortBy(fn($cw) => $cw->worker->tasks_in_progress_count) // Urutkan berdasar jumlah tugas
            ->firstWhere(fn($cw) => $cw->worker->tasks_in_progress_count < 12)?->worker;

        // Jika tidak ada pekerja yang tersedia
        if (!$worker) {
            // Berikan buffer waktu (misal, tambah 7 hari dari sekarang)
            $bufferDeadline = now()->addDays(7);
            logger('All workers in category are full. Assigning buffer deadline: ' . $bufferDeadline);

            WorkerTask::create([
                'worker_id' => null, // Tidak ada pekerja saat ini
                'order_id' => $order->id,
                'custom_request_id' => $customRequest->id,
                'task_description' => 'Tugas ditunda hingga pekerja tersedia.',
                'workflow_step_id' => null,
                'progress' => 'pending', // Status "pending"
                'deadline' => $bufferDeadline,
                'task_count' => 0,
            ]);

            return;
        }

        // Tetapkan worker pada order jika belum ada
        if (!$order->worker_id) {
            $order->worker_id = $worker->id;
            $order->save();
        }

        // Workflow Statis
        $workflows = [
            ['id' => 1, 'step_name' => 'Proses Ide', 'step_duration' => 2],
            ['id' => 2, 'step_name' => 'Proses Desain', 'step_duration' => 5],
            ['id' => 3, 'step_name' => 'Hasil Akhir', 'step_duration' => 1],
        ];

        // Cek langkah workflow yang belum dibuat
        $existingWorkflowSteps = WorkerTask::where('order_id', $order->id)
            ->where('custom_request_id', $customRequest->id)
            ->pluck('workflow_step_id')
            ->toArray();

        $filteredWorkflows = collect($workflows)
            ->whereNotIn('id', $existingWorkflowSteps);

        if ($filteredWorkflows->isEmpty()) {
            logger('No new workflows to create for Order ID: ' . $order->id);
            return;
        }

        // Cari deadline task terakhir untuk worker ini
        $lastDeadline = WorkerTask::where('worker_id', $worker->id)
            ->where('order_id', $order->id)
            ->where('custom_request_id', $customRequest->id)
            ->orderBy('deadline', 'desc')
            ->value('deadline') ?? now()->addDays(3); // 3 hari dari sekarang jika belum ada task sebelumnya

        foreach ($filteredWorkflows as $workflow) {
            logger('Creating task for Workflow Step: ' . $workflow['step_name']);

            // Mulai dari deadline task sebelumnya
            $taskStartDate = $lastDeadline; // Tanggal mulai adalah akhir dari task sebelumnya
            $taskDeadline = $taskStartDate->addDays($workflow['step_duration']); // Tambah durasi langkah

            WorkerTask::create([
                'worker_id' => $worker->id,
                'order_id' => $order->id,
                'custom_request_id' => $customRequest->id,
                'task_description' => 'Tugas untuk Custom Request: ' . $customRequest->name . ' - Step: ' . $workflow['step_name'],
                'workflow_step_id' => $workflow['id'],
                'progress' => 'not_started',
                'deadline' => $taskDeadline,
                'task_count' => 1,
            ]);

            // Perbarui lastDeadline untuk task berikutnya
            $lastDeadline = $taskDeadline;
        }

        $product = $customRequest;
        $product['title'] = $customRequest->name;

        if ($worker->user && $worker->user->email) {
            Mail::to($worker->user->email)->send(new WorkerNewOrder($worker, $order, $product));
        }
    }

    private function handleProductWorkflow(Order $order): void
    {
        $order = Order::with(['product.workflows', 'product.category', 'worker.user'])->find($order->id);

        if (!$order || !$order->product) {
            return;
        }

        $product = $order->product;

        // Cari pekerja dalam kategori produk
        $categoryWorkers = CategoryWorker::where('category_id', $product->category->id ?? null)
            ->with('worker.user')
            ->get();

        // Cari pekerja yang memiliki kurang dari 5 tugas "progress"
        $worker = $categoryWorkers
            ->sortBy(fn($cw) => $cw->worker->tasks_in_progress_count) // Urutkan berdasar jumlah tugas
            ->firstWhere(fn($cw) => $cw->worker->tasks_in_progress_count < 12)?->worker;

        // Jika tidak ada pekerja yang tersedia
        if (!$worker) {
            // Berikan buffer waktu (misal, tambah 7 hari dari sekarang)
            $bufferDeadline = now()->addDays(7);
            logger('All workers in category are full. Assigning buffer deadline: ' . $bufferDeadline);

            WorkerTask::create([
                'worker_id' => null, // Tidak ada pekerja saat ini
                'order_id' => $order->id,
                'task_description' => 'Tugas ditunda hingga pekerja tersedia.',
                'product_workflow_id' => null,
                'progress' => 'pending', // Status "pending"
                'deadline' => $bufferDeadline,
                'task_count' => 0,
            ]);

            return;
        }

        // Tetapkan worker pada order jika belum ada
        if (!$order->worker_id) {
            $order->worker_id = $worker->id;
            $order->save();
        }

        // Ambil workflow produk
        $workflows = ProductWorkflow::where('product_id', $order->product_id)
            ->orderBy('step_order')
            ->get();

        // Cek langkah workflow yang belum dibuat
        $existingTaskIds = WorkerTask::where('order_id', $order->id)
            ->pluck('product_workflow_id')
            ->toArray();

        $filteredWorkflows = $workflows->whereNotIn('id', $existingTaskIds);

        if ($filteredWorkflows->isEmpty()) {
            logger('No new workflows to create for Order ID: ' . $order->id);
            return;
        }

        // Cari deadline task terakhir untuk worker ini
        $lastDeadline = WorkerTask::where('worker_id', $worker->id)
            ->where('order_id', $order->id)
            ->orderBy('deadline', 'desc')
            ->value('deadline') ?? now()->addDays(3); // 3 hari dari sekarang jika belum ada task sebelumnya

        foreach ($filteredWorkflows as $workflow) {
            logger('Creating task for Workflow Step: ' . $workflow->step_name);

            // Mulai dari deadline task sebelumnya
            $taskStartDate = $lastDeadline; // Tanggal mulai adalah akhir dari task sebelumnya
            $taskDeadline = $taskStartDate->addDays($workflow->step_duration); // Tambah durasi langkah

            WorkerTask::create([
                'worker_id' => $worker->id,
                'order_id' => $order->id,
                'task_description' => 'Tugas untuk produk: ' . $order->product->title . ' - Step: ' . $workflow->step_name,
                'progress' => 'not_started',
                'deadline' => $taskDeadline,
                'task_count' => 1,
                'product_workflow_id' => $workflow->id,
            ]);

            // Perbarui lastDeadline untuk task berikutnya
            $lastDeadline = $taskDeadline;
        }

        if ($worker->user && $worker->user->email) {
            Mail::to($worker->user->email)->send(new WorkerNewOrder($worker, $order, $product));
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
