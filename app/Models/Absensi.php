<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';

    protected $fillable = [
        'siswa_id',
        'jadwal_id',
        'tanggal',
        'status_kehadiran',
        'nominal_kas',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function jadwal()
    {
        return $this->belongsTo(JadwalLatihan::class, 'jadwal_id');
    }
}
