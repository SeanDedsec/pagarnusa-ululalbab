<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    
    protected $table = 'siswa';
    
    protected $fillable = [
        'nama_siswa',
        'alamat',
        'no_hp',
        'tanggal_lahir',
        'status',
    ];

    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'siswa_id');
    }
}
