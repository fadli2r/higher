<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class File extends Model
{
    use HasFactory;

    protected $fillable = ['task_id', 'file_path', 'worker_id']; // Update dengan worker_id


    // Relasi ke task
    public function task()
    {
        return $this->belongsTo(WorkerTask::class, 'task_id');
    }

    public function pekerja()
    {
        return $this->belongsTo(Pekerja::class, 'worker_id');
    }
    public function workerTask()
{
    return $this->belongsTo(WorkerTask::class, 'task_id');
}
}
