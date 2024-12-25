<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'transaction_id',
        'user_id',
        'status',
        'total_amount',
        'due_date',
        'issued_date',
        'currency',
        'notes',
        'created_at',
        'updated_at',
    ];
    protected $casts = [
        'issued_date' => 'datetime',
        'due_date' => 'datetime',
    ];
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class, 'transaction_id', 'transaction_id');
    }

    public function scopeDueSoon($query)
    {
        return $query->where('due_date', '<=', now()->addDays(7))->where('status', 'pending');
    }
}
