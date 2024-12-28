<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    protected $table = 'pekerjas';  // Tabel yang sesuai di database Anda

    public function tasks()
    {
        return $this->hasMany(WorkerTask::class, 'worker_id');
    }

    public function categoryWorkers()
    {
        return $this->belongsToMany(Category::class, 'category_worker'); // Relasi ke CategoryWorker
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function jobdesc()
    {
        return $this->belongsTo(JobDesc::class, 'job_descs_id');
    }
}
