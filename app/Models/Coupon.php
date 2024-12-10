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
        'is_active',
    ];

    // Optionally, you can also specify the $casts if needed for type casting
    protected $casts = [
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];
}
