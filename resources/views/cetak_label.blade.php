<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Label - {{ $sparepart->nama_barang }}</title>
    <style>
        /* Desain Kotak Label Standar Industri */
        body { background-color: white; margin: 0; padding: 20px; }
        
        .label-box {
            width: 320px;
            padding: 15px;
            border: 2px solid #000;
            display: flex;
            align-items: center;
            font-family: 'Courier New', Courier, monospace;
            background: #fff;
            color: #000;
        }

        .qr-image {
            margin-right: 15px;
        }

        .qr-image img {
            width: 100px;
            height: 100px;
            display: block;
        }

        .info-text {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .nama-toko {
            font-size: 10px;
            font-weight: bold;
            color: #d9534f;
            text-transform: uppercase;
            border-bottom: 1px solid #000;
            margin-bottom: 5px;
            padding-bottom: 2px;
        }

        .nama-barang {
            font-size: 14px;
            font-weight: 800;
            margin-bottom: 3px;
            display: block;
            line-height: 1.2;
        }

        .kode-barang {
            font-size: 12px;
            font-weight: bold;
            background: #000;
            color: #fff;
            padding: 2px 5px;
            display: inline-block;
            width: fit-content;
        }

        /* Hilangkan tombol saat diprint */
        @media print {
            body { padding: 0; }
            .btn-print { display: none; }
        }
    </style>
</head>
<body>

    <div style="margin-bottom: 20px;" class="btn-print">
        <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer; font-weight: bold; background: #d9534f; color: white; border: none; border-radius: 5px;">
            <i class="fas fa-print"></i> KLIK CETAK LABEL SEKARANG
        </button>
        <p style="font-size: 12px; color: #666; margin-top: 5px;">*Gunakan Google Chrome untuk hasil cetak terbaik.</p>
    </div>

    <div class="label-box">
        <div class="qr-image">
           <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ $sparepart->kode_barang }}" alt="QR Code">
        </div>
        <div class="info-text">
            <span class="nama-toko">Hery Motor - Inventory</span>
            <span class="nama-barang">{{ $sparepart->nama_barang }}</span>
            <span class="kode-barang">{{ $sparepart->kode_barang }}</span>
            <small style="font-size: 8px; margin-top: 5px;">Monitoring Stok Real-Time</small>
        </div>
    </div>

    <script>
        // Memunculkan print otomatis setelah halaman selesai dimuat
        window.onload = function() {
            // Beri jeda 1 detik agar gambar QR terload sempurna dari internet sebelum print muncul
            setTimeout(function() {
                window.print();
            }, 1000);
        }
    </script>
</body>
</html>