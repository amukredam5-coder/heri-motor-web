<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Sparepart - Hery Motor</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --spark-orange: #ff4d00;
            --spark-dark: #111111;
            --spark-gray: #f5f5f5;
        }

        body { background-color: var(--spark-gray); font-family: 'Inter', sans-serif; }

        .form-card {
            background: white;
            border-radius: 2px;
            padding: 40px;
            border-top: 4px solid var(--spark-dark);
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
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
        }

        .btn-update {
            background: var(--spark-orange);
            color: white;
            border: none;
            padding: 15px;
            font-weight: 800;
            text-transform: uppercase;
            width: 100%;
        }

        .current-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border: 1px solid #ddd;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="mb-4 d-flex justify-content-between align-items-center">
                <h3 class="fw-800" style="font-family: 'Plus Jakarta Sans'; font-weight: 800;">HERY MOTOR<span style="color:var(--spark-orange)">.</span></h3>
                <a href="{{ route('sparepart.index') }}" class="btn btn-sm btn-outline-dark fw-bold text-uppercase">Batal</a>
            </div>

            <div class="form-card">
                <h4 class="fw-800 mb-4" style="font-family: 'Plus Jakarta Sans'; font-weight: 800;">EDIT DATA BARANG</h4>
                
                <form action="{{ route('sparepart.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Nama Sparepart</label>
                        <input type="text" name="nama_barang" class="form-control form-control-spark" value="{{ $item->nama_barang }}" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Merk Kendaraan</label>
                            <select name="merk" class="form-select form-select-spark" required>
                                <option value="Honda" {{ $item->merk == 'Honda' ? 'selected' : '' }}>Honda</option>
                                <option value="Yamaha" {{ $item->merk == 'Yamaha' ? 'selected' : '' }}>Yamaha</option>
                                <option value="Suzuki" {{ $item->merk == 'Suzuki' ? 'selected' : '' }}>Suzuki</option>
                                <option value="Kawasaki" {{ $item->merk == 'Kawasaki' ? 'selected' : '' }}>Kawasaki</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kategori Part</label>
                            <select name="kategori" class="form-select form-select-spark" required>
                                <option value="Shockbreaker" {{ $item->kategori == 'Shockbreaker' ? 'selected' : '' }}>Shockbreaker & Shock Depan</option>
                                <option value="Blok Mesin" {{ $item->kategori == 'Blok Mesin' ? 'selected' : '' }}>Blok Mesin & Head</option>
                                <option value="Rangka" {{ $item->kategori == 'Rangka' ? 'selected' : '' }}>Stang & Kemudi</option>
                                <option value="Footstep" {{ $item->kategori == 'Footstep' ? 'selected' : '' }}>Footstep & Pedal</option>
                                <option value="Velg" {{ $item->kategori == 'Velg' ? 'selected' : '' }}>Velg & Tromol</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stok</label>
                            <input type="number" name="stok" class="form-control form-control-spark" value="{{ $item->stok }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Harga (Rp)</label>
                            <input type="number" name="harga" class="form-control form-control-spark" value="{{ $item->harga }}" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Foto Barang</label><br>
                        @if($item->foto)
                            <img src="{{ asset('images/' . $item->foto) }}" class="current-image" alt="Foto Lama">
                            <p class="small text-muted">Foto saat ini (Biarkan jika tidak ingin diganti)</p>
                        @endif
                        <input type="file" name="foto" class="form-control form-control-spark">
                    </div>

                    <button type="submit" class="btn btn-update">Update Data Sparepart</button>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>