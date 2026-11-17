<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Keuangan;
use App\Models\LogAktivitas;
use App\Models\Pelatih; // Tambahkan ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // ... (Filter Grafik, Analisis, Siswa, Log tetap sama) ...

        $bulanGrafik = $request->input('bulan_grafik', date('m'));
        $tahunGrafik = $request->input('tahun_grafik', date('Y'));
        $startGrafik = Carbon::createFromDate($tahunGrafik, $bulanGrafik, 1)->startOfMonth();
        $endGrafik = Carbon::createFromDate($tahunGrafik, $bulanGrafik, 1)->endOfMonth();
        $chartData = Keuangan::selectRaw('DAY(tanggal) as hari, jenis_transaksi, SUM(nominal) as total')->whereBetween('tanggal', [$startGrafik, $endGrafik])->groupBy('hari', 'jenis_transaksi')->get();
        $daysInMonth = $endGrafik->daysInMonth;
        $labels = [];
        $dataMasuk = [];
        $dataKeluar = [];
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $labels[] = $i;
            $dataMasuk[] = $chartData->where('hari', $i)->where('jenis_transaksi', 'masuk')->first()->total ?? 0;
            $dataKeluar[] = $chartData->where('hari', $i)->where('jenis_transaksi', 'keluar')->first()->total ?? 0;
        }

        $bulanAnalisis = $request->input('bulan_analisis', date('m'));
        $tahunAnalisis = $request->input('tahun_analisis', date('Y'));
        $startAnalisis = Carbon::createFromDate($tahunAnalisis, $bulanAnalisis, 1)->startOfMonth();
        $endAnalisis = Carbon::createFromDate($tahunAnalisis, $bulanAnalisis, 1)->endOfMonth();
        $totalSiswa = Siswa::where('status', 'aktif')->count();
        $potensiKas = $totalSiswa * 5000 * 4;
        $realisasiKas = Keuangan::where('jenis_transaksi', 'masuk')->where('kategori', 'Kas Latihan')->whereBetween('tanggal', [$startAnalisis, $endAnalisis])->sum('nominal');
        $persentaseRealisasi = $potensiKas > 0 ? ($realisasiKas / $potensiKas) * 100 : 0;

        $bulanSiswa = $request->input('bulan_siswa', date('m'));
        $tahunSiswa = $request->input('tahun_siswa', date('Y'));
        $startSiswa = Carbon::createFromDate($tahunSiswa, $bulanSiswa, 1)->startOfMonth();
        $endSiswa = Carbon::createFromDate($tahunSiswa, $bulanSiswa, 1)->endOfMonth();
        $siswaRajin = Siswa::withCount(['absensi' => function ($query) use ($startSiswa, $endSiswa) {
            $query->where('status_kehadiran', 'hadir')->whereBetween('tanggal', [$startSiswa, $endSiswa]);
        }])->orderBy('absensi_count', 'desc')->take(5)->get();

        $bulanLog = $request->input('bulan_log', date('m'));
        $tahunLog = $request->input('tahun_log', date('Y'));
        $logs = [];
        if (Auth::user()->peran == 'super_admin') {
            $logs = LogAktivitas::with('pengguna')->whereYear('created_at', $tahunLog)->whereMonth('created_at', $bulanLog)->orderBy('created_at', 'desc')->take(5)->get();
        }

        // ==========================================
        // 5. STATISTIK GLOBAL (ALL-TIME) & TAMBAHAN
        // ==========================================
        $pendaftarBaru = Siswa::where('status', 'pending')->count();
        $totalPelatih = Pelatih::count(); // DATA BARU: Total Pelatih
        
        $totalMasukAll = Keuangan::where('jenis_transaksi', 'masuk')->sum('nominal');
        $totalKeluarAll = Keuangan::where('jenis_transaksi', 'keluar')->sum('nominal');
        $saldo = $totalMasukAll - $totalKeluarAll;

        // DATA BARU: Kas Masuk Hari Ini
        $kasHariIni = Keuangan::where('jenis_transaksi', 'masuk')->whereDate('tanggal', date('Y-m-d'))->sum('nominal');

        $transaksiTerbaru = Keuangan::orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.pages.dashboard', compact(
            'totalSiswa', 'pendaftarBaru', 'saldo', 'siswaRajin', 'transaksiTerbaru',
            'logs', 'labels', 'dataMasuk', 'dataKeluar', 
            'bulanGrafik', 'tahunGrafik', 'bulanAnalisis', 'tahunAnalisis',
            'bulanSiswa', 'tahunSiswa', 'bulanLog', 'tahunLog',
            'potensiKas', 'realisasiKas', 'persentaseRealisasi',
            'totalPelatih', 'kasHariIni' // Tambahkan ke compact
        ));
    }
}