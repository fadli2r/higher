<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Model;

class ProductWorkflow extends Model
{
    use HasFactory;
    protected $table = 'product_workflow'; // Nama tabel eksplisit


    protected $fillable = ['product_id', 'step_name', 'step_order', 'step_duration'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
