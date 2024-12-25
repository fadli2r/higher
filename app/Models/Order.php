<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'custom_request_id', 'total_price', 'order_status', 'transaction_id', 'created_at', 'updated_at'];

    /**
     * Relasi ke produk.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id'); // Mengarah ke produk
    }

public function customRequest()
{
    return $this->belongsTo(CustomRequest::class);
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
        return $this->belongsTo(Transaction::class);
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
    public function invoices()
{
    return $this->belongsToMany(Invoice::class, 'invoice_order', 'order_id', 'invoice_id');
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
