@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-0" style="font-family: 'Plus Jakarta Sans', sans-serif;">Laporan Pendapatan</h2>
        <p class="text-muted small">Ringkasan performa penjualan Hery Motor</p>
    </div>
    <button onclick="window.print()" class="btn btn-primary fw-bold px-4 py-2" style="border-radius: 10px;">
        <i class="fas fa-print me-2"></i> Cetak Laporan
    </button>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm border-0 border-start border-primary border-4" style="border-radius: 12px;">
            <div class="card-body p-4">
                <small class="text-muted fw-bold text-uppercase" style="letter-spacing: 1px;">Total Pendapatan</small>
                <h3 class="text-primary fw-800 mt-2 mb-0">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0 border-start border-success border-4" style="border-radius: 12px;">
            <div class="card-body p-4">
                <small class="text-muted fw-bold text-uppercase" style="letter-spacing: 1px;">Hari Ini</small>
                <h3 class="text-success fw-800 mt-2 mb-0">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0 border-start border-info border-4" style="border-radius: 12px;">
            <div class="card-body p-4">
                <small class="text-muted fw-bold text-uppercase" style="letter-spacing: 1px;">Transaksi Selesai</small>
                <h3 class="text-info fw-800 mt-2 mb-0">{{ $transaksiSelesai }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0" style="border-radius: 16px; background: white;">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead class="table-light">
                    <tr class="text-muted small fw-bold">
                        <th class="py-3 px-4">TANGGAL</th>
                        <th class="py-3">ORDER ID</th>
                        <th class="py-3 text-center">METODE</th>
                        <th class="py-3 text-end px-4">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($latestOrders as $order)
                    <tr>
                        <td class="text-muted small px-4">{{ $order->created_at->format('d/m/Y') }}</td>
                        <td class="fw-bold text-dark">{{ $order->order_id }}</td>
                        <td class="text-center">
                            <span class="badge bg-light text-dark border px-3 py-2" style="font-size: 10px;">
                                {{ $order->payment_type ?? 'CASH' }}
                            </span>
                        </td>
                        <td class="fw-bold text-end px-4">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    @media print {
        .navbar-hery, .btn-primary { display: none !important; }
        .content-area { padding: 0 !important; }
        body { background: white; }
        .card { box-shadow: none !important; border: 1px solid #eee !important; }
    }
</style>
@endsection