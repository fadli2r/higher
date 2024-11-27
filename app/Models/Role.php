<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Role extends Model
{
    use HasRoles;  // Menggunakan trait HasRoles untuk pengelolaan peran

    protected $table = 'roles';  // Pastikan nama tabel sesuai
    protected $fillable = ['name'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
