<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriptions extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'subscriptions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'product_id',
        'start_date',
        'end_date',
        'status',
    ];

    /**
     * Get the user associated with the subscription.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product associated with the subscription.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Scope to get active subscriptions.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Check if the subscription is expired.
     *
     * @return bool
     */
    public function isExpired()
    {
        return now()->greaterThan($this->end_date);
    }

    /**
     * Renew the subscription by extending the end date.
     *
     * @param string $period
     * @return void
     */
    public function renew($period)
    {
        if ($period === 'monthly') {
            $this->end_date = $this->end_date->addMonth();
        } elseif ($period === 'yearly') {
            $this->end_date = $this->end_date->addYear();
        }

        $this->save();
    }
}
