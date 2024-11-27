<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobDesc extends Model
{
    protected $fillable = ['name'];

    public function pekerja()
    {
        return $this->hasMany(Pekerja::class, 'job_descs_id');
    }
}
