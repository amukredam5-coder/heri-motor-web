<?php

use Illuminate\Support\Facades\Route;

// Rute tes tanpa middleware apapun untuk bypass 403
Route::get('/tes-koneksi', function () {
    return response()->json([
        'status' => 'success',
        'pesan' => 'API Heri Motor Status: ONLINE!'
    ]);
});

// Simpan rute spareparts di luar middleware auth dulu untuk tes
Route::get('/spareparts', [\App\Http\Controllers\SparepartController::class, 'getApiData']);