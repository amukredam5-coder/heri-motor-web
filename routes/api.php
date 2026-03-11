<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SparepartController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// 1. PINDAHKAN KE SINI (DI LUAR MIDDLEWARE)
// Ini agar Flutter bisa ambil data tanpa perlu login/token session
Route::get('/spareparts', [SparepartController::class, 'getApiData']);

// Rute tes untuk memastikan jembatan Vercel aktif
Route::get('/tes-koneksi', function() {
    return response()->json(['pesan' => 'API Heri Motor Status: ONLINE!']);
});


// 2. JANGAN TARUH DI DALAM GRUP INI
Route::middleware(['auth'])->group(function () {
    // Rute yang ada di dalam sini akan memberikan error 404/redirect jika diakses Flutter
});