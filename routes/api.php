<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SparepartController;

// Pintu masuk data untuk aplikasi Flutter
Route::get('/spareparts', [SparepartController::class, 'getApiData']);