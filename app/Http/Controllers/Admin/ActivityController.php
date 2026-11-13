<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kegiatan;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
     private function checkSuperAdmin()
    {
        if (Auth::user()->peran !== 'super_admin') {
            abort(403, 'Akses Ditolak. Hanya Super Admin yang dapat mengelola Kegiatan.');
        }
    }

    public function index()
    {
        $this->checkSuperAdmin();
        $kegiatan = Kegiatan::orderBy('tanggal', 'desc')->get();
        return view('admin.pages.activities', compact('kegiatan'));
    }

    public function store(Request $request)
    {
        $this->checkSuperAdmin();
        
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'lokasi' => 'required|string|max:255',
            'status_publikasi' => 'required|in:draf,publikasi',
        ]);

        Kegiatan::create($request->all());

        return redirect()->back()->with('sukses', 'Kegiatan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $this->checkSuperAdmin();

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'lokasi' => 'required|string|max:255',
            'status_publikasi' => 'required|in:draf,publikasi',
        ]);

        $kegiatan = Kegiatan::findOrFail($id);
        $kegiatan->update($request->all());

        return redirect()->back()->with('sukses', 'Kegiatan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $this->checkSuperAdmin();
        
        $kegiatan = Kegiatan::findOrFail($id);
        $kegiatan->delete();

        return redirect()->back()->with('sukses', 'Kegiatan berhasil dihapus!');
    }
}
