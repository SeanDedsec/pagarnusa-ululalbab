<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa; 
use App\Models\Absensi;
use App\Models\Keuangan;
use Illuminate\Support\Facades\DB; 

class AttendanceController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'jadwal_id' => 'required|exists:jadwal_latihan,id',
            'tanggal' => 'required|date',
            'status_kehadiran' => 'required|in:hadir,izin,sakit',
            'nominal_kas' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $absensi = Absensi::create([
                'siswa_id' => $request->siswa_id,
                'jadwal_id' => $request->jadwal_id,
                'tanggal' => $request->tanggal,
                'status_kehadiran' => $request->status_kehadiran,
                'nominal_kas' => $request->nominal_kas,
            ]);

            if ($request->nominal_kas > 0) {
                
                // AMBIL DATA SISWA UNTUK MENDAPATKAN NAMANYA
                $siswa = Siswa::find($request->siswa_id);
                $nama_siswa = $siswa ? $siswa->nama_siswa : 'ID ' . $request->siswa_id;

                Keuangan::create([
                    'tanggal' => $request->tanggal,
                    'waktu' => date('H:i:s'),
                    'jenis_transaksi' => 'masuk',
                    'kategori' => 'Kas Latihan',
                    'nominal' => $request->nominal_kas,
                    'keterangan' => 'Kas dari siswa: ' . $nama_siswa . ' (' . ucfirst($request->status_kehadiran) . ')', // <-- SUDAH MENGGUNAKAN NAMA
                    'absensi_id' => $absensi->id,
                ]);
            }

            DB::commit(); 
            return redirect()->back()->with('sukses', 'Absensi dan Kas berhasil dicatat!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function index(Request $request)
    {
        $query = Absensi::with(['siswa', 'jadwal'])->orderBy('tanggal', 'desc');

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_akhir);
        }

        if ($request->filled('status')) {
            $query->where('status_kehadiran', $request->status);
        }

        if ($request->filled('nama')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('nama_siswa', 'like', '%' . $request->nama . '%');
            });
        }

        $absensi = $query->get();

        return view('admin.pages.attendances', compact('absensi'));
    }
}