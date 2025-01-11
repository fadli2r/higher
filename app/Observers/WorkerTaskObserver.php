<?php

namespace App\Observers;

use App\Models\WorkerTask;

use App\Mail\Visualbuilder\EmailTemplates\WorkerTaskUpdate;
use Illuminate\Support\Facades\Mail;

class WorkerTaskObserver
{
    /**
     * Handle the WorkerTask "created" event.
     */
    public function created(WorkerTask $workerTask): void
    {
        $workerTask->load('order.user');

        try {
            Mail::to($workerTask->order->user->email)->send(new WorkerTaskUpdate($workerTask));
        } catch (\Throwable $th) {
            throw $th;
        };
    }

    /**
     * Handle the WorkerTask "updated" event.
     */
    public function updated(WorkerTask $workerTask): void
    {
        $workerTask->load('order.user');

        try {
            Mail::to($workerTask->order->user->email)->send(new WorkerTaskUpdate($workerTask));
        } catch (\Throwable $th) {
            throw $th;
        };

        if ($workerTask->progress === 'completed') {
            // Dapatkan semua task dari order yang sama
            $orderTasks = self::where('order_id', $workerTask->order_id)->get();

            // Periksa apakah semua task selesai
            $allTasksCompleted = $orderTasks->every(fn ($task) => $task->progress === 'completed');

            if ($allTasksCompleted) {
                // Update status order menjadi completed
                $order = Order::find($workerTask->order_id);
                if ($order && $order->order_status !== 'completed') {
                    $order->order_status = 'completed';
                    $order->save();
                }
            }
        }
    }

    /**
     * Handle the WorkerTask "deleted" event.
     */
    public function deleted(WorkerTask $workerTask): void
    {
        //
    }

    /**
     * Handle the WorkerTask "restored" event.
     */
    public function restored(WorkerTask $workerTask): void
    {
        //
    }

    /**
     * Handle the WorkerTask "force deleted" event.
     */
    public function forceDeleted(WorkerTask $workerTask): void
    {
        //
    }
}
