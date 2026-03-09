@extends('layouts.admin')

@section('content')
<div class="page-header mb-4">
    <h1 class="fw-800" style="font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800; font-size: 28px;">Manajemen Transaksi</h1>
    <p class="text-muted">Pantau dan konfirmasi pembayaran pelanggan secara real-time.</p>
</div>

<div class="card shadow-sm border-0" style="border-radius: 16px; background: white; padding: 20px;">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead class="text-primary small fw-bold text-uppercase">
                <tr>
                    <th class="border-0">Order ID</th>
                    <th class="border-0">Waktu Transaksi</th>
                    <th class="border-0">Total Pembayaran</th>
                    <th class="border-0">Status</th>
                    <th class="border-0 text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td class="fw-bold text-primary">{{ $order->order_id }}</td>
                    <td class="text-muted small">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td class="fw-bold">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</td>
                    <td>
                        @if($order->status_pesanan == 'pending')
                            <span class="badge bg-warning-subtle text-warning px-3 py-2 rounded-2" style="font-size: 10px; font-weight: 700;">PENDING</span>
                        @else
                            <span class="badge bg-success-subtle text-success px-3 py-2 rounded-2" style="font-size: 10px; font-weight: 700;">SELESAI</span>
                        @endif
                    </td>
                    <td class="text-end">
                        @if($order->status_pesanan == 'pending')
                            <form action="{{ route('order.konfirmasi', $order->id) }}" method="POST" id="form-konfirmasi-{{ $order->id }}" class="d-inline">
                                @csrf
                                <button type="button" class="btn btn-primary btn-sm fw-bold px-3 py-2" 
                                        style="font-size: 11px; border-radius: 8px; text-transform: uppercase;"
                                        onclick="confirmPayment('{{ $order->id }}', '{{ $order->order_id }}')">
                                    Konfirmasi
                                </button>
                            </form>
                        @else
                            <span class="text-success fw-bold small">
                                <i class="fas fa-check-circle me-1"></i> Selesai
                            </span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    function confirmPayment(orderId, orderCode) {
        Swal.fire({
            title: 'Konfirmasi Pelunasan?',
            text: "Pastikan pembayaran untuk " + orderCode + " telah diterima.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#004cff',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Lunas!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-konfirmasi-' + orderId).submit();
            }
        })
    }

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2000
        });
    @endif
</script>
@endsection