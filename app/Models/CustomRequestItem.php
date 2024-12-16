<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomRequestItem extends Model
{
    use HasFactory;

    protected $fillable = ['custom_request_id', 'custom_item_id', 'custom_size_id', 'quantity'];

    // Relasi dengan CustomRequest
    public function customRequest()
    {
        return $this->belongsTo(CustomRequest::class);
    }

    // Relasi dengan CustomItem (desain custom)
    public function customItem()
    {
        return $this->belongsTo(CustomItem::class);
    }

    // Relasi dengan CustomSize (ukuran desain)
    public function customSize()
    {
        return $this->belongsTo(CustomSize::class, 'custom_size_id');
    }
}
