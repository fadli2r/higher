<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'total_price', 'payment_status', 'is_subscription_payment', 'invoice_url', 'invoice_number', 'invoice_id'];


    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function invoice()
{
    return $this->hasOne(Invoice::class);
}



    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
