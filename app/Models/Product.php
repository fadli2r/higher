<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'price', 'category_id', 'file_path', 'estimated_days',
    'subscription_period', // monthly, yearly, or null for non-subscription
    'is_subscription',

    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id'); // Mengarah ke kategori produk
    }

    public function workflows(): HasMany
    {
        return $this->hasMany(ProductWorkflow::class);
    }


    public function feedbacks()
    {
    return $this->hasMany(Feedback::class);
    }
    public function isSubscription()
    {
        return $this->is_subscription;
    }

    /**
     * Get the subscriptions associated with the product.
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscriptions::class);
    }

    /**
     * Calculate price for subscription with period.
     *
     * @param string $period
     * @return float
     */
    public function calculatePrice($period)
    {
        if (!$this->isSubscription()) {
            return $this->price;
        }

        // Example: Add custom logic for pricing based on period
        return $period === 'yearly' ? $this->price * 12 * 0.9 : $this->price;
    }

}

