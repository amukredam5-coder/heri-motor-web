<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Sparepart - Hery Motor</title>
    
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
            background-color: #ffffff; 
            font-family: 'Inter', sans-serif; 
            color: var(--spark-dark);
        }

        .top-header {
            background: var(--spark-dark);
            color: white;
            padding: 12px 0;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .main-nav {
            border-bottom: 1px solid #eeeeee;
            padding: 25px 0;
            background: white;
            position: sticky;
            top: 0;
            z-index: 1050;
        }

        .brand-logo {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            font-size: 32px;
            color: var(--spark-dark);
            text-decoration: none;
        }

        .section-header {
            margin-bottom: 40px;
            border-bottom: 2px solid #eeeeee;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 10px;
        }

        .btn-add-item {
            background: var(--spark-dark);
            color: white;
            padding: 8px 20px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 700;
            font-size: 12px;
            transition: 0.3s;
        }

        .btn-add-item:hover {
            background: var(--spark-orange);
            color: white;
        }

        .empty-state-btn {
            background: var(--spark-orange);
            color: white;
            padding: 12px 25px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 800;
            display: inline-block;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="top-header text-center">
    FREE SHIPPING ON ALL ORDERS. NO MINIMUM PURCHASES*
</div>

<nav class="main-nav">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="#" class="brand-logo">HERY MOTOR<span style="color:var(--spark-orange)">.</span></a>
        <div class="d-flex align-items-center gap-3">
            <span class="small fw-bold text-uppercase">{{ auth()->user()->name }}</span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-link p-0 text-danger"><i class="fas fa-sign-out-alt"></i></button>
            </form>
        </div>
    </div>
</nav>

<div class="container my-5">
    <div class="row">
        <div class="col-lg-3">
            <div class="p-4 bg-light">
                <h5 class="fw-bold mb-3">CARI SPAREPART</h5>
                <label class="small fw-bold mb-2">MERK KENDARAAN</label>
                <select class="form-select mb-3"><option>Pilih Merk</option></select>
                <button class="btn btn-dark w-100 fw-bold">CARI BARANG</button>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="section-header">
                <h2 class="fw-extrabold m-0">New Products</h2>
                
                @if(auth()->user()->role == 'admin')
                    <a href="{{ route('sparepart.create') }}" class="btn-add-item">
                        <i class="fas fa-plus me-2"></i> TAMBAH BARANG
                    </a>
                @endif
            </div>

            <div class="row g-4">
                @forelse($semuaBarang as $item)
                    <div class="col-md-4">
                        </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-box-open fa-4x mb-3 text-muted"></i>
                        <h5 class="fw-bold text-muted">Belum ada barang di katalog.</h5>
                        
                        @if(auth()->user()->role == 'admin')
                            <a href="{{ route('sparepart.create') }}" class="empty-state-btn">
                                MULAI TAMBAH BARANG
                            </a>
                        @endif
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

</body>
</html>