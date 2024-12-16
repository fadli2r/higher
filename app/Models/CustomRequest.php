<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomRequest extends Model
{

    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'size_id',
        'custom_item_id',
        'price',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customRequestItems()
    {
        return $this->hasMany(CustomRequestItem::class);
    }

    public function customItem()
    {
        return $this->belongsTo(CustomItem::class);
    }

    public function customSize()
    {
        return $this->belongsTo(CustomSize::class);
    }
    public function cart()
    {
        return $this->hasOne(Cart::class, 'custom_request_id');
    }
// Relasi ke Order
    public function orders()
    {
        return $this->hasMany(Order::class, 'custom_request_id');
    }
}
