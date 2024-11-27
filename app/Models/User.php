<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    protected static function booted(): void
    {
        // Event ketika model User sedang dibuat

        // Event ketika model User sudah berhasil dibuat
        static::created(function (User $user) {
            // Membuat entri baru di tabel Pekerja terkait dengan user yang baru
            Pekerja::create([
                'name' => $user->name,
                'user_id' => $user->id,
                'job_descs_id' => request()->input('pekerja.job_descs_id') ?? null,  // Menambahkan job_descs_id jika ada
            ]);
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function canManageSettings()
    {
        // Logika untuk memeriksa apakah user bisa mengelola pengaturan
        return $this->hasRole('admin'); // Contoh menggunakan role
    }

    public function role()
    {
        return $this->belongsToMany(Role::class);
    }

    public function pekerja()
    {
        return $this->hasOne(Pekerja::class);
    }
    protected function afterCreate(array $data, $user): void
{
    \App\Models\Pekerja::create([
        'name' => $data['pekerja']['name'] ?? $data['name'], // Ambil nama pekerja
        'user_id' => $user->id,
        'job_descs_id' => $data['pekerja']['job_descs_id'] ?? null, // Ambil job_desc_id dari input
    ]);
}
}
