@extends('layouts.admin')

@section('content')
<style>
    :root {
        --primary-blue: #0d6efd;
        --dark-deep: #1a1c1e;
        --soft-bg: #f8f9fa;
        --card-shadow: 0 10px 40px rgba(0, 0, 0, 0.03);
    }

    body { 
        background-color: var(--soft-bg); 
        font-family: 'Inter', sans-serif; 
    }

    /* --- CART CARD STYLE --- */
    .cart-card {
        background: white;
        border-radius: 28px;
        padding: 35px;
        box-shadow: var(--card-shadow);
        border: 1px solid rgba(0,0,0,0.02);
    }

    .product-img-wrapper {
        width: 80px;
        height: 80px;
        background: #f1f3f5;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .product-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 10px;
    }

    /* --- TABLE CUSTOMIZATION --- */
    .table thead th {
        background: transparent;
        color: #b5b5c3;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        padding-bottom: 20px;
        border-bottom: 2px solid #f8faff;
    }

    .table tbody td {
        vertical-align: middle;
        padding: 25px 0;
        border-bottom: 1px solid #f8faff;
    }

    /* --- QUANTITY BADGE --- */
    .qty-display {
        background: #f1f3f5;
        color: var(--dark-deep);
        padding: 8px 20px;
        border-radius: 12px;
        font-weight: 800;
        font-size: 14px;
        display: inline-block;
    }

    /* --- SUMMARY CARD --- */
    .checkout-card {
        background: var(--dark-deep);
        color: white;
        border-radius: 28px;
        padding: 35px;
        position: sticky;
        top: 40px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }

    .btn-checkout {
        background: var(--primary-blue);
        border: none;
        border-radius: 18px;
        padding: 18px;
        font-weight: 700;
        color: white;
        transition: all 0.3s ease;
        font-size: 16px;
    }

    .btn-checkout:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(13, 110, 253, 0.4);
        background: #0056b3;
        color: white;
    }

    .btn-back {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: white;
        border-radius: 14px;
        color: var(--dark-deep);
        box-shadow: var(--card-shadow);
        transition: 0.3s;
        text-decoration: none;
    }

    .btn-back:hover {
        background: var(--dark-deep);
        color: white;
    }

    .trash-btn {
        color: #ef4444;
        background: #fff5f5;
        border: none;
        width: 38px;
        height: 38px;
        border-radius: 10px;
        transition: 0.3s;
    }

    .trash-btn:hover {
        background: #ef4444;
        color: white;
    }
</style>

<div class="container-fluid py-4 px-lg-5">
    <div class="d-flex align-items-center justify-content-between mb-5">
        <div class="d-flex align-items-center">
            <a href="{{ route('reseller.dashboard') }}" class="btn btn-back me-3">
                <i class="fas fa-chevron-left"></i>
            </a>
            <div>
                <h2 class="fw-bold m-0" style="font-family: 'Plus Jakarta Sans';">Review Pesanan</h2>
                <p class="text-muted m-0">Pastikan item dan jumlahnya sudah sesuai.</p>
            </div>
        </div>
        <div class="d-none d-md-block text-end">
            <span class="badge bg-white text-dark border px-3 py-2 rounded-pill shadow-sm">
                <i class="fas fa-shopping-basket text-primary me-2"></i>{{ session('cart') ? count(session('cart')) : 0 }} Produk Terpilih
            </span>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger border-0 rounded-4 shadow-sm mb-4">
            <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
        </div>
    @endif

    <div class="row g-5">
        <div class="col-xl-8">
            <div class="cart-card">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>DETAIL PRODUK</th>
                                <th>HARGA SATUAN</th>
                                <th class="text-center">QTY</th>
                                <th>TOTAL</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0 @endphp
                            @if(session('cart') && count(session('cart')) > 0)
                                @foreach(session('cart') as $id => $details)
                                    @php $total += $details['price'] * $details['quantity'] @endphp
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="product-img-wrapper me-3">
                                                    @if(isset($details['photo']) && $details['photo'])
                                                        <img src="{{ asset('storage/' . $details['photo']) }}" onerror="this.src='{{ asset('images/' . $details['photo']) }}'">
                                                    @else
                                                        <i class="fas fa-tools text-muted opacity-50"></i>
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark fs-6">{{ $details['name'] }}</div>
                                                    <div class="text-muted small" style="letter-spacing: 0.5px;">ID: #{{ $id }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="fw-semibold text-dark">
                                            Rp{{ number_format($details['price'], 0, ',', '.') }}
                                        </td>
                                        <td class="text-center">
                                            <div class="qty-display">
                                                {{ $details['quantity'] }}
                                            </div>
                                        </td>
                                        <td class="fw-bold text-primary">
                                            Rp{{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}
                                        </td>
                                        <td class="text-end">
                                            <form action="{{ route('cart.remove', $id) }}" method="POST" onsubmit="return confirm('Hapus barang ini dari keranjang?')">
                                                @csrf 
                                                @method('DELETE')
                                                <button type="submit" class="trash-btn shadow-sm">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="py-5">
                                            <img src="https://illustrations.popsy.co/blue/shopping-cart.svg" style="width: 220px;" class="mb-4 opacity-75">
                                            <h4 class="fw-bold text-dark">Keranjang Kosong</h4>
                                            <p class="text-muted mb-4">Sepertinya Anda belum memilih sparepart apa pun.</p>
                                            <a href="{{ route('reseller.dashboard') }}" class="btn btn-primary px-5 py-3 rounded-pill fw-bold" style="text-decoration: none;">
                                                Jelajahi Katalog Barang
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="checkout-card">
                <h4 class="fw-bold mb-4" style="font-family: 'Plus Jakarta Sans';">Summary</h4>
                
                <div class="d-flex justify-content-between mb-3 opacity-75">
                    <span>Subtotal Barang</span>
                    <span class="fw-bold">Rp{{ number_format($total, 0, ',', '.') }}</span>
                </div>
                
                <div class="d-flex justify-content-between mb-4 opacity-75">
                    <span>Total Item</span>
                    <span class="fw-bold">{{ session('cart') ? count(session('cart')) : 0 }} Jenis</span>
                </div>

                <div class="p-3 rounded-4 mb-4" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-store-alt me-2 text-primary"></i>
                        <span class="small fw-bold">Metode Pengambilan</span>
                    </div>
                    <div class="small opacity-75">Ambil Langsung / Tunai di Bengkel Hery Motor</div>
                </div>
                
                <hr class="my-4" style="border-color: rgba(255,255,255,0.1); border-style: dashed;">
                
                <div class="d-flex justify-content-between align-items-center mb-5">
                    <span class="fs-6 opacity-75">Total Estimasi</span>
                    <h2 class="fw-bold m-0" style="color: var(--primary-blue);">Rp{{ number_format($total, 0, ',', '.') }}</h2>
                </div>

                @if(session('cart') && count(session('cart')) > 0)
                <form action="{{ route('cart.checkout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-checkout w-100 mb-3 shadow">
                        Lanjut Checkout <i class="fas fa-arrow-right ms-2"></i>
                    </button>
                </form>
                @endif
                
                <div class="text-center">
                    <p class="m-0" style="font-size: 11px; color: rgba(255,255,255,0.4);">
                        <i class="fas fa-shield-alt me-1"></i> Transaksi Aman & Terverifikasi
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: "{{ session('success') }}",
        background: '#ffffff',
        confirmButtonColor: '#1a1c1e',
        customClass: {
            popup: 'rounded-4'
        }
    });
</script>
@endif
@endsection