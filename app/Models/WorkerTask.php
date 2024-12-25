<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkerTask extends Model
{
    protected $fillable = [
        'worker_id', 'order_id', 'task_description', 'progress', 'deadline',
        'task_count', 'product_workflow_id','file_path', 'created_at', 'updated_at'
    ];
    protected $dates = [ 'deadline' => 'datetime'];
    protected static function booted()
    {
        static::updated(function (WorkerTask $workerTask) {
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
        });
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function worker()
    {
        return $this->belongsTo(Pekerja::class, 'worker_id');
    }

    public function workflow()
    {
        return $this->belongsTo(ProductWorkflow::class); // Relasi ke ProductWorkflow
    }
    public function productWorkflow()
    {
        return $this->belongsTo(ProductWorkflow::class, 'product_workflow_id');
    }

    public function files()
    {
        return $this->hasMany(File::class, 'task_id');
    }
    public function pekerja()
{
    return $this->belongsTo(Pekerja::class, 'worker_id');
}
public function revisions()
{
    return $this->hasMany(Revision::class, 'task_id');
}
}
