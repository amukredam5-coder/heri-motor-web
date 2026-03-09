<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sparepart extends Model
{
    use HasFactory;

    protected $table = 'spareparts';

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'stok',
        'harga',
        'foto',
        'merk',      // Kolom baru
        'kategori',  // Kolom baru
    ];
}