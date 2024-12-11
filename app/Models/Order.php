<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'worker_id',
        'total_price',
        'order_status',
    ];

    /**
     * Relasi ke produk.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id'); // Mengarah ke produk
    }

    /**
     * Relasi ke user (pelanggan).
     */
    public function user()
    {
        return $this->belongsTo(User::class); // Relasi ke User
    }

    /**
     * Relasi ke pekerja.
     */
    public function worker()
    {
        return $this->belongsTo(Pekerja::class, 'worker_id'); // Relasi ke Pekerja
    }

    /**
     * Relasi ke transaksi.
     */
    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'order_id', 'id'); // Relasi ke transaksi
    }
    public function workerTasks()
    {
        return $this->hasMany(WorkerTask::class);
    }
    /**
     * Relasi ke kategori produk.
     */
    public function category()
    {
        return $this->product->category(); // Mengarah ke kategori produk yang terkait
    }

    /**
     * Mengambil informasi pekerja melalui category_worker (jika diperlukan)
     */
    public function categoryWorker()
    {
        return $this->hasOneThrough(
            Pekerja::class, // Model pekerja
            CategoryWorker::class, // Model category_worker
            'category_id', // Foreign key di CategoryWorker
            'id', // Foreign key di Pekerja
            'product_id', // Local key di Order (relasi ke produk)
            'worker_id' // Local key di CategoryWorker (relasi ke pekerja)
        );
    }

    public function scopeWithRelations($query)
    {
        return $query->with(['product.category', 'worker.user', 'worker.categoryWorkers']);
    }
}
