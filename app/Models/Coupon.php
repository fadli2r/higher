<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory;

    // Add 'code' to the fillable array to allow mass assignment
    protected $fillable = [
        'code',
        'discount_value',
        'discount_type',
        'expires_at',
        'max_discount_value',
        'is_active',
    ];

    public function regenerate($newExpiresAt = null)
    {
        $newCoupon = $this->replicate(); // Clone current coupon
        $newCoupon->expires_at = $newExpiresAt ?? now()->addDays(30); // Default to 30 days if no new date is provided
        $newCoupon->is_active = true; // Activate the coupon
        $newCoupon->save(); // Save the new coupon
        return $newCoupon;
    }
    public function usages()
    {
        return $this->hasMany(CouponUsage::class);
    }

    public function totalUsages()
    {
        return $this->usages()->count();
    }
    // Optionally, you can also specify the $casts if needed for type casting
    protected $casts = [
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];
}
