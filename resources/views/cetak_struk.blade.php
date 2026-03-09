<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Pembayaran - {{ $order->order_id }}</title>
    <style>
        body { font-family: 'Courier New', Courier, monospace; width: 300px; margin: auto; padding: 20px; border: 1px solid #eee; }
        .text-center { text-align: center; }
        hr { border-top: 1px dashed #000; }
        .flex { display: flex; justify-content: space-between; }
    </style>
</head>
<body onload="window.print()">
    <div class="text-center">
        <h3>HERY MOTOR</h3>
        <p>Jl. Raya Utama No. 123<br>Bekasi, Indonesia</p>
    </div>
    <hr>
    <p>ID: {{ $order->order_id }}</p>
    <p>Tgl: {{ $order->created_at->format('d/m/Y H:i') }}</p>
    <hr>
    <div class="flex">
        <span>Total Bayar:</span>
        <span>Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</span>
    </div>
    <div class="flex">
        <span>Metode:</span>
        <span>{{ strtoupper(str_replace('_', ' ', $order->metode_pembayaran)) }}</span>
    </div>
    <div class="flex">
        <span>Status:</span>
        <span>{{ strtoupper($order->status_pesanan) }}</span>
    </div>
    <hr>
    <p class="text-center">Terima Kasih Atas Kepercayaan Anda!</p>
</body>
</html>