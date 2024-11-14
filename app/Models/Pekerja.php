<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pekerja extends Model
{
    public function jobDesc()
    {
        return $this->belongsTo(JobDesc::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
