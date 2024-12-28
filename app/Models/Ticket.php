<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'status',
    ];

    public function messages()
    {
        return $this->hasMany(TicketMessage::class, 'ticket_id'); // Pastikan ticket_id digunakan sebagai foreign key
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

