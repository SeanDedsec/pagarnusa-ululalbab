<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Pelatih;
use App\Models\Pengaturan;
use Barryvdh\DomPDF\Facade\Pdf;

class RegistrationController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_siswa' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_hp' => 'required|numeric',
            'tanggal_lahir' => 'required|date',
        ]);

        $validatedData['status'] = 'pending';
        $siswa = Siswa::create($validatedData);

        $pelatih = Pelatih::first();
        $no_hp_pelatih = $pelatih ? $pelatih->no_hp : (Pengaturan::where('kunci', 'no_hp')->first()->nilai ?? '08123456789');

        return redirect()->back()->with([
            'sukses' => 'Pendaftaran berhasil!',
            'siswa_id' => $siswa->id,
            'no_hp_pelatih' => $no_hp_pelatih
        ]);
    }

    public function cetakBukti($id)
    {
        $siswa = Siswa::findOrFail($id);
        $pdf = Pdf::loadView('pdf.bukti_pendaftaran', compact('siswa'));
        return $pdf->download('Bukti_Pendaftaran_' . str_replace(' ', '_', $siswa->nama_siswa) . '.pdf');
    }
}