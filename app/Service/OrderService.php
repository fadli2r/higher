<?php

namespace App\Services;

use App\Models\CategoryWorker;
use App\Models\Order;
use App\Models\ProductWorkflow;
use App\Models\WorkerTask;

class OrderService
{
    public function assignWorkerAndTasks(Order $order): void
    {
        if ($order->order_status === 'in_progress') {
            $order->load(['product.workflows', 'product.category']);

            $product = $order->product;
            $category = $product->category;

            $worker = CategoryWorker::where('category_id', $category->id)->first()?->worker;

            if ($worker && $worker->user) {
                $order->update(['worker_id' => $worker->id]);
                $this->createWorkerTasks($order, $product, $worker);
            }
        }
    }

    private function createWorkerTasks(Order $order, $product, $worker): void
    {
         // Ambil workflow yang belum dibuatkan task
    $existingTasks = WorkerTask::where('order_id', $order->id)
    ->pluck('product_workflow_id')
    ->toArray();

$workflows = ProductWorkflow::where('product_id', $product->id)
    ->whereNotIn('id', $existingTasks)
    ->orderBy('step_order')
    ->get();

// Tentukan deadline untuk setiap tugas berdasarkan step_order
$lastDeadline = now();

foreach ($workflows as $workflow) {
    $lastDeadline = $lastDeadline->addDays($workflow->step_duration);

    WorkerTask::create([
        'worker_id' => $worker->id,
        'order_id' => $order->id,
        'task_description' => 'Tugas untuk produk: ' . $product->title . ' - Step: ' . $workflow->step_name,
        'progress' => 'not_started',
        'deadline' => $lastDeadline,
        'task_count' => 1,
        'product_workflow_id' => $workflow->id,
    ]);
}
    }
}
