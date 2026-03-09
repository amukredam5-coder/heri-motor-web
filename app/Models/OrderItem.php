<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'order_items';

    // Kolom yang boleh diisi (Mass Assignment)
    protected $fillable = [
        'order_id',
        'sparepart_id',
        'jumlah',
        'harga_satuan'
    ];

    /**
     * RELASI KE ORDER
     * Menghubungkan item ini kembali ke pesanan induknya.
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * RELASI KE SPAREPART
     * Digunakan untuk mengambil nama barang, foto, atau kode barang 
     * dari tabel spareparts saat menampilkan detail pesanan.
     */
    public function sparepart()
    {
        return $this->belongsTo(Sparepart::class, 'sparepart_id');
    }
}