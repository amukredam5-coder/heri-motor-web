<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'orders';

    // Kolom yang boleh diisi
    protected $fillable = [
        'order_id',
        'reseller_id',
        'total_bayar',
        'status_pesanan',
        'metode_pembayaran'
    ];

    /**
     * RELASI KE USER (Reseller)
     * Menghubungkan pesanan dengan siapa yang membelinya.
     */
    public function reseller()
    {
        return $this->belongsTo(User::class, 'reseller_id');
    }

    /**
     * RELASI KE ORDER ITEMS
     * Menghubungkan pesanan dengan daftar barang yang dibeli (banyak barang).
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
}