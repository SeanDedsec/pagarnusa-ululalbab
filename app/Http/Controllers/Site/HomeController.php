<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Pelatih;
use App\Models\JadwalLatihan;
use App\Models\Kegiatan;
use App\Models\Keuangan;
use App\Models\Pengaturan;
use App\Models\Galeri;

class HomeController extends Controller
{
    public function index()
    {
        $pelatih = Pelatih::all();
        $jadwal = JadwalLatihan::all();
        
        // Kegiatan yang dipublikasi
        $kegiatan = Kegiatan::with('galeri')->where('status_publikasi', 'publikasi')->orderBy('tanggal', 'desc')->take(3)->get();

        // Galeri yang dipublikasi (ambil 6 foto terbaru)
        $galeri = Galeri::where('status_publikasi', 'publikasi')->orderBy('tanggal', 'desc')->take(6)->get();

        // Transparansi Keuangan
        $totalMasuk = Keuangan::where('jenis_transaksi', 'masuk')->sum('nominal');
        $totalKeluar = Keuangan::where('jenis_transaksi', 'keluar')->sum('nominal');
        $saldo = $totalMasuk - $totalKeluar;

        $identitas = [
            'nama_organisasi' => Pengaturan::where('kunci', 'nama_organisasi')->first()->nilai ?? 'Pagar Nusa Ranting Mancar Ulul-Albab',
            'alamat' => Pengaturan::where('kunci', 'alamat')->first()->nilai ?? 'Desa Mancar, Kec. Peterongan, Jombang',
            'no_hp' => Pengaturan::where('kunci', 'no_hp')->first()->nilai ?? '08123456789',
        ];

        return view('site.home', compact('pelatih', 'jadwal', 'kegiatan', 'galeri', 'totalMasuk', 'totalKeluar', 'saldo', 'identitas'));
    }
}