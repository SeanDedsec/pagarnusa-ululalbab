<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JadwalLatihan extends Model
{
    use HasFactory;

    protected $table = 'jadwal_latihan';

    protected $fillable = [
        'hari',
        'jam_mulai',
        'jam_selesai',
        'keterangan',
    ];
}
