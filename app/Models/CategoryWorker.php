<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryWorker extends Model
{
    protected $table = 'category_worker';  // Nama tabel yang sesuai

    public $timestamps = false;

    protected $fillable = [
        'category_id',
        'worker_id',
        'assigned_at',
    ];

    // Relasi ke Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Relasi ke Pekerja
    public function worker()
    {
        return $this->belongsTo(Pekerja::class, 'worker_id');
    }
}
