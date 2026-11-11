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
                Keuangan::create([
                    'tanggal' => $request->tanggal,
                    'jenis_transaksi' => 'masuk',
                    'kategori' => 'Kas Latihan',
                    'nominal' => $request->nominal_kas,
                    'keterangan' => 'Kas dari siswa ID: ' . $request->siswa_id . ' (' . $request->status_kehadiran . ')',
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
}