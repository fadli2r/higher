<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'total_price', 'payment_status', 'is_subscription_payment', 'invoice_url', 'invoice_number', 'invoice_id', 'down_payment', 'remaining_payment', 'payment_method', 'payment_date', 'payment_due_date', 'payment_status', 'status', 'created_at', 'updated_at'];


    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'transaction_id');
    }



    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
