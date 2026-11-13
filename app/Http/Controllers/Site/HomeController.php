<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pelatih;
use App\Models\JadwalLatihan;
use App\Models\Kegiatan;
use App\Models\Keuangan;

class HomeController extends Controller
{
    public function index()
    {
        $pelatih = Pelatih::all();
        $jadwal = JadwalLatihan::all();
        
        $kegiatan = Kegiatan::with('galeri')->where('status_publikasi', 'publikasi')->orderBy('tanggal', 'desc')->take(3)->get();

        $totalMasuk = Keuangan::where('jenis_transaksi', 'masuk')->sum('nominal');
        $totalKeluar = Keuangan::where('jenis_transaksi', 'keluar')->sum('nominal');
        $saldo = $totalMasuk - $totalKeluar;

        return view('site.home', compact('pelatih', 'jadwal', 'kegiatan', 'totalMasuk', 'totalKeluar', 'saldo'));
    }
}
