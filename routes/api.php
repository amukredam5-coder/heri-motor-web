<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SparepartController;

// 1. Ambil data (GET) - ini sudah ada di gambar kamu
Route::get('/spareparts', [SparepartController::class, 'getApiData']);