<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomSize extends Model
{
    use HasFactory;
    protected $table = 'custom_sizes';

    protected $fillable = ['size_name', 'additional_price'];

    // Relasi dengan CustomRequestItem
    public function customRequestItems()
    {
        return $this->hasMany(CustomRequestItem::class);
    }
}
