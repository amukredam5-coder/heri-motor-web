<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
  public function run(): void
{
    // Menghapus data lama dengan email tersebut
    \App\Models\User::where('email', 'admin@gmail.com')->delete();

    // Membuat akun baru dengan sandi yang Anda inginkan
    \App\Models\User::create([
        'name' => 'Admin Hery',
        'email' => 'admin@gmail.com',
        'password' => \Illuminate\Support\Facades\Hash::make('admin12345'), // Ganti sesuai keinginan Anda
    ]);
}
}