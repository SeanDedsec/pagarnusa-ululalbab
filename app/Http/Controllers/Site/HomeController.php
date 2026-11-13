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
        // Ambil data dari database
        $pelatih = Pelatih::all();
        $jadwal = JadwalLatihan::all();
        
        // Hanya tampilkan kegiatan yang sudah dipublikasi
        $kegiatan = Kegiatan::where('status_publikasi', 'publikasi')->orderBy('tanggal', 'desc')->take(3)->get();

        // Hitung total transparansi keuangan
        $totalMasuk = Keuangan::where('jenis_transaksi', 'masuk')->sum('nominal');
        $totalKeluar = Keuangan::where('jenis_transaksi', 'keluar')->sum('nominal');
        $saldo = $totalMasuk - $totalKeluar;

        return view('site.home', compact('pelatih', 'jadwal', 'kegiatan', 'totalMasuk', 'totalKeluar', 'saldo'));
    }
}
