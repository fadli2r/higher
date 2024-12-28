<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pekerja extends Model
{
    protected $fillable = ['name', 'job_descs_id', 'user_id'];
    protected $table = 'pekerjas';
    protected static function booted()
    {
        static::saving(function ($pekerja) {
            if (!$pekerja->name) {
                $pekerja->name = $pekerja->user->name ?? 'Tanpa Nama'; // Isi otomatis dari relasi user
            }
        });
    }

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
    public function files()
    {
        return $this->hasMany(File::class, 'worker_id');  // Relasi dengan worker_id
    }

}
