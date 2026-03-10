<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SparepartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| 1. ROUTE UMUM (LOGIN & REDIRECT)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    if (Auth::check()) {
        $role = Auth::user()->role;
        // Diperbaiki: Arahkan ke sparepart.index agar user bisa lihat barang dulu
        return redirect()->route('sparepart.index');
    }
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| 2. GRUP ROUTE (WAJIB LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |--- KHUSUS ADMIN ---
    */
    // Note: Karena Anda pakai Laravel 11, pastikan 'role' sudah ada di bootstrap/app.php
    Route::middleware(['role:admin'])->group(function () {
        
        // Dashboard Admin (Halaman Utama Admin)
        Route::get('/admin/dashboard', [OrderController::class, 'index'])->name('admin.dashboard');

        // Inventaris (Full Akses) - Disesuaikan dengan URL di index.blade.php Anda
        Route::get('/admin/spareparts/create', [SparepartController::class, 'create'])->name('sparepart.create');
        Route::post('/admin/spareparts/store', [SparepartController::class, 'store'])->name('sparepart.store');
        Route::get('/admin/spareparts/{id}/edit', [SparepartController::class, 'edit'])->name('sparepart.edit');
        Route::put('/admin/spareparts/{id}', [SparepartController::class, 'update'])->name('sparepart.update');
        Route::delete('/admin/spareparts/{id}', [SparepartController::class, 'destroy'])->name('sparepart.destroy');
        Route::get('/admin/spareparts/cetak-label/{id}', [SparepartController::class, 'cetakLabel'])->name('sparepart.cetak');

        // Manajemen Transaksi & Laporan
        // Perbaikan: Hindari duplikasi rute /admin/orders jika fungsinya sama dengan dashboard
        Route::get('/admin/orders', [OrderController::class, 'index'])->name('order.index');
        Route::post('/admin/orders/{id}/konfirmasi', [OrderController::class, 'konfirmasi'])->name('order.konfirmasi');
        Route::get('/admin/laporan', [OrderController::class, 'laporan'])->name('order.laporan');

        // Notifikasi Admin
        Route::post('/admin/mark-notifications-read', [OrderController::class, 'markAsRead'])->name('markNotifRead');
        Route::get('/admin/check-notifications', function (Request $request) {
            $user = auth()->user();
            if ($request->has('on_page') && $request->on_page == 'order_index') {
                $user->unreadNotifications->markAsRead();
                return response()->json(['unread_count' => 0]);
            }
            return response()->json([
                'unread_count' => $user->unreadNotifications->count(),
                'latest' => $user->unreadNotifications->first()
            ]);
        });
    });

    /*
    |--- KHUSUS RESELLER ---
    */
    Route::middleware(['role:reseller'])->group(function () {
        Route::get('/reseller/dashboard', [OrderController::class, 'dashboardReseller'])->name('reseller.dashboard');
        Route::get('/cart', [OrderController::class, 'viewCart'])->name('cart.index');
        Route::post('/cart/add/{id}', [OrderController::class, 'addToCart'])->name('cart.add'); 
        Route::post('/cart/update', [OrderController::class, 'updateCart'])->name('cart.update');
        Route::delete('/cart/remove/{id}', [OrderController::class, 'removeFromCart'])->name('cart.remove');
        Route::post('/cart/checkout', [OrderController::class, 'checkout'])->name('cart.checkout');
        Route::get('/orders/{id}/cetak', [OrderController::class, 'cetakStruk'])->name('order.cetak');
    });

    /*
    |--- BISA DIAKSES KEDUANYA ---
    */
    // Route ini menampilkan katalog yang ada di index.blade.php Anda
    Route::get('/inventory', [SparepartController::class, 'index'])->name('sparepart.index');
});
use Illuminate\Support\Facades\DB;

Route::get('/cek-data', function () {
    // 1. Perintah untuk mengambil data asli dari database
    $parts = DB::table('spareparts')->get(); 

    $html = "<html><head><title>Data Sparepart Heri Motor</title>
             <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css'>
             </head><body class='p-5'>
             <div class='container'>
                 <h2 class='mb-4 text-center'>Daftar Persediaan Sparepart - Heri Motor</h2>
                 <table class='table table-bordered table-striped'>
                    <thead class='table-dark text-center'>
                        <tr>
                            <th>Kode</th><th>Nama Barang</th><th>Stok</th><th>Harga</th><th>Merk</th><th>Kategori</th>
                        </tr>
                    </thead>
                    <tbody>";

    // 2. Perulangan (Looping) untuk menampilkan setiap data dari HeidiSQL
    foreach ($parts as $p) {
        $html .= "<tr>
                    <td>{$p->kode_barang}</td>
                    <td>{$p->nama_barang}</td>
                    <td class='text-center'>{$p->stok}</td>
                    <td>Rp " . number_format($p->harga, 0, ',', '.') . "</td>
                    <td>{$p->merk}</td>
                    <td>{$p->kategori}</td>
                  </tr>";
    }

    $html .= "</tbody></table></div></body></html>";
    return $html;
});
