<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Keuangan extends Model
{
    use HasFactory;

    protected $table = 'keuangan';

    protected $fillable = [
        'tanggal',
        'jenis_transaksi',
        'kategori',
        'nominal',
        'keterangan',
        'absensi_id',
    ];
}
