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

        $worker = Worker::withCount(['tasksInProgress'])
            ->orderBy('tasks_in_progress_count')
            ->first();

        $bufferDays = 0;

        if (!$worker || $worker->tasks_in_progress_count >= 12) {
            // Jika pekerja penuh, tambahkan buffer 5 hari
            $bufferDays = 5;
        }

        if (!$worker) {
            // Jika tidak ada pekerja tersedia, buat buffer task
            $bufferDeadline = now()->addDays($bufferDays);
            WorkerTask::create([
                'worker_id' => null,
                'order_id' => $order->id,
                'custom_request_id' => $customRequest->id,
                'task_description' => 'Tugas ditunda hingga pekerja tersedia.',
                'workflow_step_id' => null,
                'progress' => 'pending',
                'deadline' => $bufferDeadline,
            ]);
            return;
        }

        if (!$order->worker_id) {
            $order->worker_id = $worker->id;
            $order->save();
        }

        // Workflow task
        $workflows = [
            ['id' => 1, 'step_name' => 'Proses Ide', 'step_duration' => 2],
            ['id' => 2, 'step_name' => 'Proses Desain', 'step_duration' => 5],
            ['id' => 3, 'step_name' => 'Hasil Akhir', 'step_duration' => 1],
        ];

        $existingWorkflowSteps = WorkerTask::where('order_id', $order->id)
            ->pluck('workflow_step_id')
            ->toArray();

        $filteredWorkflows = collect($workflows)->whereNotIn('id', $existingWorkflowSteps);

        // Mulai dari sekarang + buffer
        $lastDeadline = WorkerTask::where('worker_id', $worker->id)
            ->orderBy('deadline', 'desc')
            ->value('deadline') ?? now();

        $lastDeadline = $lastDeadline->addDays($bufferDays);

        foreach ($filteredWorkflows as $workflow) {
            // Tambahkan durasi pengerjaan task ke deadline terakhir
            $taskDeadline = $lastDeadline->addDays($workflow['step_duration']);

            WorkerTask::create([
                'worker_id' => $worker->id,
                'order_id' => $order->id,
                'custom_request_id' => $customRequest->id,
                'task_description' => 'Tugas untuk Custom Request: ' . $customRequest->name . ' - Step: ' . $workflow['step_name'],
                'workflow_step_id' => $workflow['id'],
                'progress' => 'not_started',
                'deadline' => $taskDeadline,
            ]);

            // Perbarui lastDeadline untuk task berikutnya
            $lastDeadline = $taskDeadline;
        }

        $product = $customRequest;
        $product['title'] = $customRequest->name;

        if ($worker->user && $worker->user->email) {
            Mail::to($worker->user->email)->send(new WorkerNewOrder($worker, $order, $product, $worker->user));
        }
    }

    private function handleProductWorkflow(Order $order): void
    {
        $order = Order::with(['product.workflows', 'product.category', 'worker'])->find($order->id);

        if (!$order || !$order->product) {
            logger('Order or Product not found for Order ID: ' . $order->id);
            return;
        }

        $product = $order->product;

        // Ambil pekerja dalam kategori produk
        $categoryWorkers = CategoryWorker::where('category_id', $product->category->id ?? null)
            ->with('worker')
            ->get();

        // Filter pekerja yang memiliki tugas < 12 atau ambil pekerja secara acak
        $workers = $categoryWorkers->map(fn($cw) => $cw->worker)
            ->filter() // Pastikan worker tidak null
            ->unique('id'); // Hindari duplikasi

        if ($workers->isEmpty()) {
            logger('No workers found for product category ID: ' . $product->category->id);
            return;
        }

        $worker = $workers
            ->sortBy(fn($worker) => $worker->tasksInProgress()->count())
            ->firstWhere(fn($worker) => $worker->tasksInProgress()->count() < 12);

        $bufferDays = 0;

        if (!$worker) {
            // Jika semua worker penuh, tambahkan buffer 7 hari dan pilih secara acak
            $bufferDays = 7;
            $worker = $workers->random();

            if (!$worker) {
                logger('No workers available after random selection.');
                return;
            }
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

        // Tentukan deadline terakhir atau fallback ke waktu sekarang
        $lastDeadline = WorkerTask::where('worker_id', $worker->id)
            ->orderBy('deadline', 'desc')
            ->value('deadline');

        $lastDeadline = $lastDeadline ? \Carbon\Carbon::parse($lastDeadline) : now();
        $lastDeadline = $lastDeadline->addDays($bufferDays); // Tambahkan buffer jika worker penuh

        foreach ($filteredWorkflows as $workflow) {
            logger('Creating task for Workflow Step: ' . $workflow->step_name);

            // Tentukan deadline untuk langkah ini
            $taskDeadline = $lastDeadline->copy()->addDays($workflow->step_duration);

            WorkerTask::create([
                'worker_id' => $worker->id,
                'order_id' => $order->id,
                'task_description' => 'Tugas untuk produk: ' . $product->title . ' - Step: ' . $workflow->step_name,
                'progress' => 'not_started',
                'deadline' => $taskDeadline,
                'task_count' => 1,
                'product_workflow_id' => $workflow->id,
            ]);

            // Perbarui lastDeadline untuk task berikutnya
            $lastDeadline = $taskDeadline;
        }

        if ($worker->user && $worker->user->email) {
            Mail::to($worker->user->email)->send(new WorkerNewOrder($worker, $order, $product, $worker->user));
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
