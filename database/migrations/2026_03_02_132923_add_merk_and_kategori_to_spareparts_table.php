<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration untuk menambah kolom.
     */
    public function up(): void
    {
        Schema::table('spareparts', function (Blueprint $table) {
            // Menambahkan kolom merk dan kategori setelah kolom harga
            $table->string('merk')->nullable()->after('harga');
            $table->string('kategori')->nullable()->after('merk');
        });
    }

    /**
     * Batalkan migration (Rollback).
     */
    public function down(): void
    {
        Schema::table('spareparts', function (Blueprint $table) {
            $table->dropColumn(['merk', 'kategori']);
        });
    }
};