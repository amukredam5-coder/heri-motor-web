<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Hery Motor</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        body { background-color: #fcfcfc; font-family: 'Inter', sans-serif; padding-top: 80px; }
        .navbar-custom {
            background: white; box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            padding: 15px 5%; position: fixed; top: 0; width: 100%; z-index: 1000;
        }
        .brand-logo { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800; font-size: 22px; color: #111; text-decoration: none; }
        .brand-logo span { color: #004cff; }
        .nav-item-custom { color: #666; text-decoration: none; font-weight: 600; font-size: 14px; margin-left: 25px; transition: 0.3s; }
        .nav-item-custom:hover, .nav-item-custom.active { color: #004cff; }
        .content-area { max-width: 1200px; margin: 40px auto; padding: 0 20px; }
    </style>
</head>
<body>

<nav class="navbar-custom d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center">
        <a href="/" class="brand-logo">HERY<span>MOTOR</span></a>
        <div class="ms-4">
            <a href="{{ route('sparepart.index') }}" class="nav-item-custom {{ Request::is('inventory*') ? 'active' : '' }}"><i class="fas fa-th-large me-1"></i> Dashboard</a>
            <a href="{{ route('order.index') }}" class="nav-item-custom {{ Request::is('admin/orders*') ? 'active' : '' }}"><i class="fas fa-exchange-alt me-1"></i> Transaksi</a>
            <a href="{{ route('order.laporan') }}" class="nav-item-custom {{ Request::is('admin/laporan*') ? 'active' : '' }}"><i class="fas fa-chart-pie me-1"></i> Laporan</a>
        </div>
    </div>
    <div class="d-flex align-items-center gap-3">
        <div class="text-end border-end pe-3">
            <div class="fw-bold small">{{ Auth::user()->name }}</div>
            <small class="text-muted" style="font-size: 10px;">ADMINISTRATOR</small>
        </div>
        <form action="{{ route('logout') }}" method="POST" class="m-0">
            @csrf
            <button type="submit" class="btn text-danger p-0"><i class="fas fa-sign-out-alt"></i></button>
        </form>
    </div>
</nav>

<div class="content-area">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>