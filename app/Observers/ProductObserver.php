<?php

namespace App\Observers;

use App\Models\Product;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        $totalDuration = $product->workflows()->sum('step_duration');

        // Update kolom estimated_days tanpa memicu event lagi
        $product->updateQuietly(['estimated_days' => $totalDuration]);
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        $totalDuration = $product->workflows()->sum('step_duration');

        // Update kolom estimated_days tanpa memicu event lagi
        $product->updateQuietly(['estimated_days' => $totalDuration]);
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function saved(Product $product)
{
    $totalDuration = $product->workflows()->sum('step_duration');
    $product->updateQuietly(['estimated_days' => $totalDuration]); // Hindari loop
}

    public function deleted(Product $product)
    {
        // Jika produk dihapus, Anda bisa menghapus data terkait jika diperlukan
        $product->workflows()->delete();
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product): void
    {
        //
    }
}
