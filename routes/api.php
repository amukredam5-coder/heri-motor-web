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
use Illuminate\Support\Facades\DB;

Route::get('/cek-database', function () {
    try {
        // Ganti 'spareparts' dengan nama tabel yang ingin kamu lihat
        $data = DB::table('spareparts')->get(); 
        return response()->json([
            'status' => 'success',
            'jumlah_data' => $data->count(),
            'data' => $data
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'pesan' => $e->getMessage()
        ], 500);
    }
});