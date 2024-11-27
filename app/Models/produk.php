<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'Produk';
    protected $primaryKey = 'ID_Produk'; // Primary key yang benar

    protected $fillable = [
        'Nama_Produk',
        'Deskripsi',
        'Harga',
        'Stok',
        'Kategori',
        'Tipe_Produk',
        'Kustom_Detail',
        'Durasi',
        'Status_Produk',
    ];

    // Relasi dengan Pesanan
    //public function pesanan()
    //{
      //  return $this->hasMany(Pesanan::class, 'ID_Produk');
    //}
}
