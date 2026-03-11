<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SparepartController;

// 1. Ambil data (GET) - ini sudah ada di gambar kamu
Route::get('/spareparts', [SparepartController::class, 'getApiData']);
Route::get('/tes-koneksi', function() {
    return response()->json([
        'status' => 'Berhasil',
        'pesan' => 'API Heri Motor sudah Online!',
        'data' => 'Siap digunakan untuk Flutter'
    ]);
});