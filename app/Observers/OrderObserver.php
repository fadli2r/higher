<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\Worker;
use App\Models\WorkerTask;
use App\Models\ProductWorkflow;
use App\Models\User;
use App\Models\CategoryWorker;  // Model CategoryWorker
use App\Jobs\CreateWorkerTask;
use App\Models\CustomRequest;
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

    $worker = CategoryWorker::whereHas('category', function ($query) {
        $query->where('name', 'like', '%Desain%');
    })->first()?->worker;

    if (!$worker) {
        logger('No worker found for category Desain in Order ID: ' . $order->id);
        return;
    }

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

    // Cek apakah sudah ada WorkerTask untuk langkah ini
    $existingWorkflowSteps = WorkerTask::where('order_id', $order->id)
        ->where('custom_request_id', $customRequest->id)
        ->pluck('workflow_step_id')
        ->toArray();

    // Filter hanya workflow yang belum ada
    $filteredWorkflows = collect($workflows)
        ->whereNotIn('id', $existingWorkflowSteps);

    if ($filteredWorkflows->isEmpty()) {
        logger('No new workflows to create for Order ID: ' . $order->id);
        return;
    }

    $lastDeadline = WorkerTask::where('order_id', $order->id)
        ->where('custom_request_id', $customRequest->id)
        ->max('deadline') ?? now();

    foreach ($filteredWorkflows as $workflow) {
        logger('Creating task for Workflow Step: ' . $workflow['step_name']);
        $lastDeadline = $lastDeadline->addDays($workflow['step_duration']);

        WorkerTask::create([
            'worker_id' => $worker->id,
            'order_id' => $order->id,
            'custom_request_id' => $customRequest->id,
            'task_description' => 'Tugas untuk Custom Request: ' . $customRequest->name . ' - Step: ' . $workflow['step_name'],
            'workflow_step_id' => $workflow['id'],
            'progress' => 'not_started',
            'deadline' => $lastDeadline,
            'task_count' => 1,
        ]);
    }
}



private function handleProductWorkflow(Order $order): void
{
    // Logika yang sudah ada untuk produk
    $order = Order::with(['product.workflows', 'product.category', 'worker'])->find($order->id);

    if (!$order || !$order->product) {
        return;
    }

    $product = $order->product;

    $worker = CategoryWorker::where('category_id', $product->category->id ?? null)
                            ->first()?->worker;

    if ($worker) {
        if (!$order->worker_id) {
            $order->worker_id = $worker->id;
            $order->save();
        }

        $this->assignWorkflowsToWorker($order, $worker);
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
