<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomRequest extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'custom_item_id', 'custom_size_id', 'description', 'price', 'status'];

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
}
