<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'price', 'category_id', 'file_path', 'estimated_days'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function workflows(): HasMany
    {
        return $this->hasMany(ProductWorkflow::class);
    }
    public function calculateEstimatedDays()
    {
        // Mengambil semua workflow yang terkait dengan produk ini
        $totalDuration = $this->workflows->sum('step_duration'); // Menjumlahkan step_duration

        // Menyimpan total durasi ke field estimated_days
        $this->update(['estimated_days' => $totalDuration]);
    }

    // Hook after saving the product
    protected static function booted()
    {
        static::saved(function ($product) {
            // Hitung ulang estimated_days setelah produk disimpan
            $product->calculateEstimatedDays();
        });
    }
}

