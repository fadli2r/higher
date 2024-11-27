<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'price', 'category_id', 'file_path', 'estimated_days'];

    // Relasi ke kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke workflow
    public function workflows()
    {
        return $this->hasMany(ProductWorkflow::class);
    }
}
