<?php

namespace App\Jobs;

use App\Http\Resources\Products;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CalculateEstimatedDaysJob implements ShouldQueue
{
    use Queueable;

    protected $productId;

    public function __construct($productId)
    {
        $this->productId = $productId;
    }

    public function handle()
    {
        ini_set('memory_limit', '256M');

        // Memuat ulang model dengan relasi
        $product = Product::with('workflows')->find($this->productId);

        if (!$product) {
            logger("Product with ID {$this->productId} not found.");
            return;
        }

        try {
            // Menghitung total durasi dari workflows
            $totalDuration = $product->workflows->sum('step_duration');

            // Memperbarui kolom estimated_days di produk
            $product->update(['estimated_days' => $totalDuration]);

            logger("Updated estimated_days for product ID: {$this->productId}");
        } catch (\Exception $e) {
            logger("Failed to calculate estimated days for product ID: {$this->productId}. Error: {$e->getMessage()}");
        }
    }
}

