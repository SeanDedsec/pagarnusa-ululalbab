<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;

class PenggunaSeeder extends Seeder
{
    public function run(): void
    {
        Pengguna::create([
            'nama_lengkap' => 'Super Admin Pagar Nusa',
            'username' => 'superadmin',
            'password' => Hash::make('password123'),
            'peran' => 'super_admin',
            'status_akun' => 'aktif',
        ]);
    }
}