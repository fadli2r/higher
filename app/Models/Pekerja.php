<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pekerja extends Model
{
    protected $fillable = ['name', 'job_descs_id', 'user_id'];
    protected $table = 'pekerjas';

    public function jobDesc()
    {
        return $this->belongsTo(JobDesc::class, 'job_descs_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function categoryWorkers()
    {
        return $this->hasMany(CategoryWorker::class, 'worker_id');
    }

    public function tasks()
    {
        return $this->hasMany(WorkerTask::class); // Setiap pekerja bisa memiliki banyak tugas
    }

}
