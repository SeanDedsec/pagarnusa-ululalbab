<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Keuangan;
use App\Models\LogAktivitas;
use App\Models\Pelatih;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // ==========================================
        // 1. FILTER KHUSUS GRAFIK
        // ==========================================
        $bulanGrafik = $request->input('bulan_grafik', date('m'));
        $tahunGrafik = $request->input('tahun_grafik', date('Y'));
        
        $startGrafik = Carbon::createFromDate($tahunGrafik, $bulanGrafik, 1)->startOfMonth();
        $endGrafik = Carbon::createFromDate($tahunGrafik, $bulanGrafik, 1)->endOfMonth();

        $chartData = Keuangan::selectRaw('DAY(tanggal) as hari, jenis_transaksi, SUM(nominal) as total')
            ->whereBetween('tanggal', [$startGrafik, $endGrafik])
            ->groupBy('hari', 'jenis_transaksi')
            ->get();
            
        $daysInMonth = $endGrafik->daysInMonth;
        $labels = [];
        $dataMasuk = [];
        $dataKeluar = [];
        
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $labels[] = $i;
            $dataMasuk[] = $chartData->where('hari', $i)->where('jenis_transaksi', 'masuk')->first()->total ?? 0;
            $dataKeluar[] = $chartData->where('hari', $i)->where('jenis_transaksi', 'keluar')->first()->total ?? 0;
        }

        // ==========================================
        // 2. FILTER KHUSUS ANALISIS KAS
        // ==========================================
        $bulanAnalisis = $request->input('bulan_analisis', date('m'));
        $tahunAnalisis = $request->input('tahun_analisis', date('Y'));

        $startAnalisis = Carbon::createFromDate($tahunAnalisis, $bulanAnalisis, 1)->startOfMonth();
        $endAnalisis = Carbon::createFromDate($tahunAnalisis, $bulanAnalisis, 1)->endOfMonth();

        $totalSiswa = Siswa::where('status', 'aktif')->count();
        $potensiKas = $totalSiswa * 5000 * 4; 
        $realisasiKas = Keuangan::where('jenis_transaksi', 'masuk')
            ->where('kategori', 'Kas Latihan')
            ->whereBetween('tanggal', [$startAnalisis, $endAnalisis])
            ->sum('nominal');
            
        $persentaseRealisasi = $potensiKas > 0 ? ($realisasiKas / $potensiKas) * 100 : 0;

        // ==========================================
        // 3. FILTER KHUSUS SISWA PALING RAJIN (PAGINATION)
        // ==========================================
        $bulanSiswa = $request->input('bulan_siswa', date('m'));
        $tahunSiswa = $request->input('tahun_siswa', date('Y'));

        $startSiswa = Carbon::createFromDate($tahunSiswa, $bulanSiswa, 1)->startOfMonth();
        $endSiswa = Carbon::createFromDate($tahunSiswa, $bulanSiswa, 1)->endOfMonth();

        $siswaRajin = Siswa::withCount(['absensi' => function ($query) use ($startSiswa, $endSiswa) {
            $query->where('status_kehadiran', 'hadir')->whereBetween('tanggal', [$startSiswa, $endSiswa]);
        }])->orderBy('absensi_count', 'desc')
           ->paginate(5, ['*'], 'page_siswa') // Gunakan page_siswa agar tidak bentrok
           ->appends($request->all());

        // ==========================================
        // 4. FILTER KHUSUS LOG AKTIVITAS
        // ==========================================
        $bulanLog = $request->input('bulan_log', date('m'));
        $tahunLog = $request->input('tahun_log', date('Y'));

        $logs = [];
        if (Auth::user()->peran == 'super_admin') {
            $logs = LogAktivitas::with('pengguna')
                ->whereYear('created_at', $tahunLog)
                ->whereMonth('created_at', $bulanLog)
                ->orderBy('created_at', 'desc')
                ->paginate(5)
                ->appends($request->all());
        }

        // ==========================================
        // 5. STATISTIK GLOBAL & TRANSAKSI (PAGINATION)
        // ==========================================
        $pendaftarBaru = Siswa::where('status', 'pending')->count();
        $totalPelatih = Pelatih::count();
        
        $totalMasukAll = Keuangan::where('jenis_transaksi', 'masuk')->sum('nominal');
        $totalKeluarAll = Keuangan::where('jenis_transaksi', 'keluar')->sum('nominal');
        $saldo = $totalMasukAll - $totalKeluarAll;

        $kasHariIni = Keuangan::where('jenis_transaksi', 'masuk')->whereDate('tanggal', date('Y-m-d'))->sum('nominal');

        // Ubah menjadi paginate dan gunakan page_transaksi
        $transaksiTerbaru = Keuangan::orderBy('created_at', 'desc')
            ->paginate(5, ['*'], 'page_transaksi')
            ->appends($request->all());

        return view('admin.pages.dashboard', compact(
            'totalSiswa', 'pendaftarBaru', 'saldo', 'siswaRajin', 'transaksiTerbaru',
            'logs', 'labels', 'dataMasuk', 'dataKeluar', 
            'bulanGrafik', 'tahunGrafik', 'bulanAnalisis', 'tahunAnalisis',
            'bulanSiswa', 'tahunSiswa', 'bulanLog', 'tahunLog',
            'potensiKas', 'realisasiKas', 'persentaseRealisasi',
            'totalPelatih', 'kasHariIni'
        ));
    }
}