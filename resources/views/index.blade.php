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
            --text-muted: #666666;
        }

        body { 
            background-color: #ffffff; 
            font-family: 'Inter', sans-serif; 
            color: var(--spark-dark);
            -webkit-font-smoothing: antialiased;
        }

        .top-header {
            background: var(--spark-dark);
            color: white;
            padding: 12px 0;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1.2px;
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
            letter-spacing: -1.8px;
            color: var(--spark-dark);
            text-decoration: none;
        }

        .nav-menu-link {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--spark-dark) !important;
            text-decoration: none;
            letter-spacing: 0.5px;
        }

        .nav-menu-link:hover {
            color: var(--spark-orange) !important;
        }

        .filter-container {
            background: var(--spark-gray);
            padding: 30px;
            border-radius: 2px;
        }

        .filter-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            font-size: 20px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .form-select-spark {
            border-radius: 0;
            border: 1px solid #e0e0e0;
            padding: 12px;
            font-size: 14px;
            margin-bottom: 12px;
            background-color: white;
            font-weight: 600;
        }

        .btn-spark-search {
            background: var(--spark-orange);
            color: white;
            border: none;
            border-radius: 2px;
            padding: 15px;
            width: 100%;
            font-weight: 800;
            text-transform: uppercase;
            font-size: 14px;
            transition: 0.3s;
        }

        .btn-spark-search:hover {
            background: #e64500;
            transform: translateY(-2px);
        }

        .section-header {
            margin-bottom: 40px;
            border-bottom: 2px solid #eeeeee;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 15px;
        }

        .section-title-line {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            font-size: 28px;
            margin: 0;
            position: relative;
        }

        .section-title-line::after {
            content: '';
            position: absolute;
            bottom: -17px;
            left: 0;
            width: 80px;
            height: 3px;
            background: var(--spark-dark);
        }

        .btn-add-item {
            background: var(--spark-dark);
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            font-weight: 800;
            font-size: 12px;
            text-transform: uppercase;
        }

        .product-item {
            position: relative;
            padding: 10px;
            transition: 0.3s;
            height: 100%;
        }

        .product-item:hover {
            box-shadow: 0 15px 40px rgba(0,0,0,0.08);
        }

        .image-box {
            background: #ffffff;
            height: 280px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            padding: 20px;
        }

        .image-box img {
            max-height: 100%;
            max-width: 100%;
            object-fit: contain;
        }

        .item-code {
            font-size: 11px;
            font-weight: 700;
            color: #999;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .item-price {
            font-weight: 800;
            font-size: 18px;
        }

        .admin-controls {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 5;
            display: flex;
            flex-direction: column;
            gap: 8px;
            opacity: 0;
            transition: 0.3s;
        }

        .product-item:hover .admin-controls {
            opacity: 1;
        }

        .ctrl-btn {
            width: 35px;
            height: 35px;
            background: white;
            border: 1px solid #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: var(--spark-dark);
            text-decoration: none;
        }
        
        .ctrl-btn:hover {
            background: var(--spark-dark);
            color: white;
        }
    </style>
</head>
<body>

<div class="top-header text-center">
    FREE SHIPPING ON ALL ORDERS. NO MINIMUM PURCHASES*
</div>

<nav class="main-nav">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="{{ url('/') }}" class="brand-logo">HERY MOTOR<span style="color:var(--spark-orange)">.</span></a>
        
        <div class="d-flex align-items-center gap-5">
            <div class="d-none d-lg-flex gap-4">
                <a href="{{ url('/') }}" class="nav-menu-link">Home</a>
                <a href="{{ url('/') }}" class="nav-menu-link">Spareparts</a>
                
                @if(Auth::check() && Auth::user()->role === 'admin')
                    <a href="{{ url('/admin/dashboard') }}" class="nav-menu-link">Dashboard</a>
                    <a href="{{ url('/admin/orders') }}" class="nav-menu-link">Laporan</a>
                @endif
            </div>

            <div class="d-flex gap-3 align-items-center">
                <i class="fas fa-search"></i>
                <div class="position-relative me-2">
                    <i class="fas fa-shopping-cart" style="font-size: 18px;"></i>
                    <span class="badge rounded-pill bg-danger position-absolute top-0 start-100 translate-middle" style="font-size: 9px;">0</span>
                </div>
                
                @auth
                <div class="border-start ps-3 d-flex align-items-center">
                    <span class="small fw-bold text-uppercase">
                        {{ Auth::user()->name }} 
                        <span class="badge bg-dark ms-1" style="font-size: 9px;">{{ strtoupper(Auth::user()->role) }}</span>
                    </span>
                    <form action="{{ route('logout') }}" method="POST" class="ms-2">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 text-danger" title="Logout"><i class="fas fa-sign-out-alt"></i></button>
                    </form>
                </div>
                @else
                <a href="{{ route('login') }}" class="nav-menu-link border-start ps-3">Login</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<div class="container my-5">
    <div class="row g-5">
        <div class="col-lg-3">
            <div class="filter-container">
                <div class="filter-title">Cari Sparepart</div>
                <p class="small text-muted mb-4">Temukan komponen motor Anda.</p>
                
                <form action="{{ url('/') }}" method="GET">
                    <label class="small fw-bold text-uppercase mb-2">Merk Kendaraan</label>
                    <select name="merk" class="form-select form-select-spark">
                        <option value="">Semua Merk</option>
                        <option value="Honda" {{ request('merk') == 'Honda' ? 'selected' : '' }}>Honda</option>
                        <option value="Yamaha" {{ request('merk') == 'Yamaha' ? 'selected' : '' }}>Yamaha</option>
                        <option value="Suzuki" {{ request('merk') == 'Suzuki' ? 'selected' : '' }}>Suzuki</option>
                        <option value="Kawasaki" {{ request('merk') == 'Kawasaki' ? 'selected' : '' }}>Kawasaki</option>
                    </select>

                    <label class="small fw-bold text-uppercase mb-2">Kategori Part</label>
                    <select name="kategori" class="form-select form-select-spark">
                        <option value="">Semua Kategori</option>
                        <option value="Shockbreaker" {{ request('kategori') == 'Shockbreaker' ? 'selected' : '' }}>Rangka</option>
                        <option value="Blok Mesin" {{ request('kategori') == 'Blok Mesin' ? 'selected' : '' }}>Suspensi</option>
                        <option value="Rangka" {{ request('kategori') == 'Rangka' ? 'selected' : '' }}>Akeseoris</option>
                    </select>
                    
                    <button type="submit" class="btn btn-spark-search mt-3">Cari Barang</button>
                </form>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="section-header">
                <h2 class="section-title-line">NEW PRODUCTS</h2>
                @if(Auth::check() && Auth::user()->role === 'admin')
                    <a href="{{ url('/admin/spareparts/create') }}" class="btn-add-item"><i class="fas fa-plus me-1"></i> Tambah Barang</a>
                @endif
            </div>

            <div class="row g-4">
                @forelse($semuaBarang as $item)
                <div class="col-md-4">
                    <div class="product-item border">
                        @if(Auth::check() && Auth::user()->role === 'admin')
                        <div class="admin-controls">
                            <a href="{{ url('/admin/spareparts/'.$item->id.'/edit') }}" class="ctrl-btn" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                            <form action="{{ url('/admin/spareparts/'.$item->id) }}" method="POST" onsubmit="return confirm('Hapus barang ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="ctrl-btn border-0"><i class="fas fa-trash text-danger"></i></button>
                            </form>
                        </div>
                        @endif

                        <div class="image-box">
                            <img src="{{ asset('images/' . $item->foto) }}" alt="{{ $item->nama_barang }}" onerror="this.src='https://placehold.co/400x400?text=No+Image'">
                        </div>
                        <div class="text-center p-2">
                            <div class="item-code">{{ $item->kode_barang }}</div>
                            <h6 class="fw-bold">{{ strtoupper($item->nama_barang) }}</h6>
                            <div class="item-price">Rp {{ number_format($item->harga, 0, ',', '.') }}</div>
                            <div class="small text-muted mb-2">Stok: {{ $item->stok }}</div>
                            <button class="btn btn-outline-dark w-100 rounded-0 mt-2 fw-bold">ADD TO CART</button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5 text-muted">
                    Tidak ada barang ditemukan.
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>