<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'order_id',
        'payment_status',
        'invoice_url',
        'invoice_number',
        'invoice_id'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
