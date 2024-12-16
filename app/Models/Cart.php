<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id', 'product_id', 'custom_request_id', 'quantity'];

    /**
     * Get all of the comments for the Cart
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function customRequest()
    {
        return $this->belongsTo(CustomRequest::class, 'custom_request_id');
    }
}
