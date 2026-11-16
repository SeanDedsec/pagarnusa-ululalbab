<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class StudentController extends Controller
{
    public function index()
    {
        $siswa = Siswa::orderBy('created_at', 'desc')->get();
        return view('admin.pages.students', compact('siswa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_siswa' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_hp' => 'required|numeric',
            'tanggal_lahir' => 'required|date',
        ]);

        Siswa::create([
            'nama_siswa' => $request->nama_siswa,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'tanggal_lahir' => $request->tanggal_lahir,
            'status' => 'aktif',
        ]);

        LogAktivitas::create([
            'pengguna_id' => Auth::id(),
            'aksi' => 'Tambah',
            'modul' => 'Data Siswa',
            'keterangan' => 'Menambahkan siswa: ' . $request->nama_siswa,
        ]);

        return redirect()->back()->with('sukses', 'Data siswa berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_siswa' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_hp' => 'required|numeric',
            'tanggal_lahir' => 'required|date',
            'status' => 'required|in:pending,aktif,nonaktif'
        ]);

        $siswa = Siswa::findOrFail($id);
        $siswa->update($request->all());

        LogAktivitas::create([
            'pengguna_id' => Auth::id(),
            'aksi' => 'Edit',
            'modul' => 'Data Siswa',
            'keterangan' => 'Mengubah data siswa: ' . $siswa->nama_siswa,
        ]);

        return redirect()->back()->with('sukses', 'Data siswa berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);

        LogAktivitas::create([
            'pengguna_id' => Auth::id(),
            'aksi' => 'Hapus',
            'modul' => 'Data Siswa',
            'keterangan' => 'Menghapus siswa: ' . $siswa->nama_siswa,
        ]);

        $siswa->delete();

        return redirect()->back()->with('sukses', 'Data siswa berhasil dihapus!');
    }

    public function cetakPdf()
    {
        $siswa = Siswa::orderBy('nama_siswa', 'asc')->get();
        $pdf = Pdf::loadView('pdf.laporan_siswa', compact('siswa'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('Laporan_Data_Siswa_PagarNusa.pdf');
    }
}