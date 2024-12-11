<?php

namespace App\Jobs;

use App\Http\Resources\Products;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CalculateEstimatedDaysJob implements ShouldQueue
{
    use Queueable;
    protected $product;

    // Menyimpan produk yang diterima dari constructor
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function handle()
    {
        ini_set('memory_limit', '256M');
        // Menghitung total durasi dari workflows
        $totalDuration = $this->product->workflows()->sum('step_duration');

        // Memperbarui kolom estimated_days di produk
        $this->product->update(['estimated_days' => $totalDuration]);
    }
}
