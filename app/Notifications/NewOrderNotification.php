<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewOrderNotification extends Notification
{
    use Queueable;

    protected $order;

    /**
     * Kita masukkan data Order ke dalam Constructor
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Kita ganti 'mail' menjadi 'database' agar notifikasi 
     * tersimpan di database dan muncul di web/desktop.
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Struktur data yang akan disimpan di tabel 'notifications'
     */
    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->order_id,
            'total'    => $this->order->total_bayar,
            'customer' => 'Reseller Hery Motor', // Bisa ganti $this->order->reseller->nama jika ada relasi
            'message'  => 'Ada pesanan baru masuk senilai Rp' . number_format($this->order->total_bayar, 0, ',', '.'),
            'link'     => route('admin.orders.index'), // Link untuk Admin langsung ke daftar order
        ];
    }
}