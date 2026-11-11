<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;

class StudentController extends Controller
{
    // 1. Menampilkan halaman dan data siswa
    public function index()
    {
        $siswa = Siswa::orderBy('created_at', 'desc')->get();
        return view('admin.pages.students', compact('siswa'));
    }

    // 2. Menyimpan data siswa baru (dari Admin)
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
            'status' => 'aktif', // Admin menambah data = langsung aktif
        ]);

        return redirect()->back()->with('sukses', 'Data siswa berhasil ditambahkan!');
    }

    // 3. Mengupdate data siswa
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

        return redirect()->back()->with('sukses', 'Data siswa berhasil diperbarui!');
    }

    // 4. Menghapus data siswa
    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();

        return redirect()->back()->with('sukses', 'Data siswa berhasil dihapus!');
    }
}