<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SparepartController;

// RUTE INI BEBAS DIAKSES SIAPA SAJA (TERMASUK FLUTTER)
Route::get('/spareparts', [SparepartController::class, 'getApiData']);

// Rute tes koneksi (opsional)
Route::get('/tes-koneksi', function() {
    return response()->json(['pesan' => 'API Berhasil Terkoneksi!']);
});