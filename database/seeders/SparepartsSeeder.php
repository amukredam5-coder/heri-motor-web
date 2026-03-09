<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SparepartsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
{
    \DB::table('spareparts')->insert([
        [
            'kode_barang' => 'HM-001',
            'nama_barang' => 'Lowering Kit CBR', // Ganti di sini
            'stok' => 10,
            'harga' => 250000,
            'foto' => 'lowering_cbr.jpg', // Tambahkan kolom foto
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'kode_barang' => 'HM-002',
            'nama_barang' => 'Lowering Standard', // Ganti di sini
            'stok' => 15,
            'harga' => 150000,
            'foto' => 'lowering.jpg', // Tambahkan kolom foto
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ]);
}
}
