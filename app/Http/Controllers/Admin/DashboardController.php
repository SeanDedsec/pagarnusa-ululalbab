<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Keuangan;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Statistik Dasar
        $totalSiswa = Siswa::where('status', 'aktif')->count();
        $pendaftarBaru = Siswa::where('status', 'pending')->count();
        
        // 2. Statistik Keuangan
        $totalMasuk = Keuangan::where('jenis_transaksi', 'masuk')->sum('nominal');
        $totalKeluar = Keuangan::where('jenis_transaksi', 'keluar')->sum('nominal');
        $saldo = $totalMasuk - $totalKeluar;

        // 3. Siswa Paling Rajin (Top 5 berdasarkan jumlah kehadiran 'hadir')
        $siswaRajin = Siswa::withCount(['absensi' => function ($query) {
            $query->where('status_kehadiran', 'hadir');
        }])->orderBy('absensi_count', 'desc')->take(5)->get();

        // 4. Transaksi Terbaru (5 data terakhir)
        $transaksiTerbaru = Keuangan::orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.pages.dashboard', compact(
            'totalSiswa', 
            'pendaftarBaru', 
            'saldo', 
            'siswaRajin', 
            'transaksiTerbaru'
        ));
    }
}
