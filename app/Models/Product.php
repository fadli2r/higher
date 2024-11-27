<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'price', 'category_id', 'file_path', 'estimated_days'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function workflows()
    {
        return $this->hasMany(ProductWorkflow::class, 'product_id', 'id'); // Nama tabel: product_workflow
    }
}

