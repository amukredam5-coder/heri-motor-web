<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Sparepart - Hery Motor</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --spark-orange: #ff4d00;
            --spark-dark: #111111;
            --spark-gray: #f5f5f5;
        }

        body { 
            background-color: var(--spark-gray); 
            font-family: 'Inter', sans-serif; 
            color: var(--spark-dark);
        }

        .form-card {
            background: white;
            border-radius: 2px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            padding: 40px;
            border-top: 4px solid var(--spark-orange);
        }

        .brand-logo {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            font-size: 24px;
            color: var(--spark-dark);
            text-decoration: none;
            letter-spacing: -1px;
        }

        .form-label {
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #666;
        }

        .form-control-spark, .form-select-spark {
            border-radius: 0;
            border: 1px solid #e0e0e0;
            padding: 12px;
            font-size: 14px;
        }

        .form-control-spark:focus, .form-select-spark:focus {
            border-color: var(--spark-orange);
            box-shadow: none;
        }

        .btn-save {
            background: var(--spark-dark);
            color: white;
            border: none;
            padding: 15px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            width: 100%;
            transition: 0.3s;
        }

        .btn-save:hover {
            background: var(--spark-orange);
            color: white;
        }
    </style>
</head>
<body>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="mb-4 d-flex justify-content-between align-items-center">
                <a href="{{ route('sparepart.index') }}" class="brand-logo">HERY MOTOR<span style="color:var(--spark-orange)">.</span></a>
                <a href="{{ route('sparepart.index') }}" class="btn btn-sm btn-outline-dark fw-bold text-uppercase" style="font-size: 10px;">Kembali</a>
            </div>

            <div class="form-card">
                <h4 class="fw-800 mb-4" style="font-family: 'Plus Jakarta Sans'; font-weight: 800;">TAMBAH BARANG BARU</h4>
                
                <form action="{{ route('sparepart.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Nama Sparepart</label>
                        <input type="text" name="nama_barang" class="form-control form-control-spark" placeholder="Contoh: Shockbreaker Tabung" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Merk Kendaraan</label>
                            <select name="merk" class="form-select form-select-spark" required>
                                <option value="">-- Pilih Merk --</option>
                                <option value="Honda">Honda</option>
                                <option value="Yamaha">Yamaha</option>
                                <option value="Suzuki">Suzuki</option>
                                <option value="Kawasaki">Kawasaki</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kategori Part</label>
                            <select name="kategori" class="form-select form-select-spark" required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="Shockbreaker">Shockbreaker & Shock Depan</option>
                                <option value="Blok Mesin">Blok Mesin & Head</option>
                                <option value="Rangka">Stang & Kemudi</option>
                                <option value="Footstep">Footstep & Pedal</option>
                                <option value="Velg">Velg & Tromol</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stok</label>
                            <input type="number" name="stok" class="form-control form-control-spark" placeholder="0" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Harga (Rp)</label>
                            <input type="number" name="harga" class="form-control form-control-spark" placeholder="500000" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Foto Barang</label>
                        <input type="file" name="foto" class="form-control form-control-spark" required>
                        <small class="text-muted" style="font-size: 10px;">Format: JPG, PNG (Max 2MB)</small>
                    </div>

                    <button type="submit" class="btn btn-save">Simpan ke Katalog</button>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>