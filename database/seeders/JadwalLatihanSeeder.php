<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JadwalLatihanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('jadwal_latihan')->insert([
            ['hari' => 'Minggu', 'jam_mulai' => '15:00:00', 'jam_selesai' => '17:00:00', 'keterangan' => 'Latihan Sore', 'created_at' => now(), 'updated_at' => now()],
            ['hari' => 'Kamis', 'jam_mulai' => '15:00:00', 'jam_selesai' => '17:00:00', 'keterangan' => 'Latihan Sore', 'created_at' => now(), 'updated_at' => now()],
            ['hari' => 'Senin', 'jam_mulai' => '19:00:00', 'jam_selesai' => '22:00:00', 'keterangan' => 'Latihan Malam', 'created_at' => now(), 'updated_at' => now()],
            ['hari' => 'Kamis', 'jam_mulai' => '19:00:00', 'jam_selesai' => '22:00:00', 'keterangan' => 'Latihan Malam', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
