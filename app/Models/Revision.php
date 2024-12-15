<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Revision extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'requested_by',
        'description',
        'status',
    ];

    /**
     * Relasi ke tugas pekerja (WorkerTask)
     */
    public function workerTask()
    {
        return $this->belongsTo(WorkerTask::class, 'task_id');
    }

    /**
     * Relasi ke pengguna yang mengajukan revisi
     */
    public function requestedBy()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }
}
