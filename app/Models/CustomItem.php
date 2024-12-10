<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class CustomItem extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'base_price'];

    // Relasi dengan CustomRequestItem (untuk menyimpan item yang dipilih dalam pesanan)
    public function customRequestItems()
    {
        return $this->hasMany(CustomRequestItem::class);
    }
}
