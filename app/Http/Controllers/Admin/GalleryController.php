<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Galeri;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Kegiatan;

class GalleryController extends Controller
{
    private function checkSuperAdmin()
    {
        if (Auth::user()->peran !== 'super_admin') {
            abort(403, 'Akses Ditolak. Hanya Super Admin yang dapat mengelola Galeri.');
        }
    }

    public function index()
    {
        $this->checkSuperAdmin();
        $galeri = Galeri::with('kegiatan')->orderBy('tanggal', 'desc')->get();
        $kegiatan = Kegiatan::orderBy('tanggal', 'desc')->get();
        return view('admin.pages.galleries', compact('galeri', 'kegiatan'));
    }

    public function store(Request $request)
    {
        $this->checkSuperAdmin();
        
        $request->validate([
            'judul' => 'required|string|max:255',
            'file_foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'tanggal' => 'required|date',
            'status_publikasi' => 'required|in:draf,publikasi',
            'kegiatan_id' => 'nullable|exists:kegiatan,id',
        ]);

        $path = $request->file('file_foto')->store('galeri', 'public');

        Galeri::create([
            'judul' => $request->judul,
            'file_foto' => $path,
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
            'status_publikasi' => $request->status_publikasi,
            'kegiatan_id' => $request->kegiatan_id,
        ]);

        return redirect()->back()->with('sukses', 'Foto galeri berhasil diunggah!');
    }

        public function update(Request $request, $id)
    {
        $this->checkSuperAdmin();
        
        $request->validate([
            'judul' => 'required|string|max:255',
            'file_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tanggal' => 'required|date',
            'status_publikasi' => 'required|in:draf,publikasi',
            'kegiatan_id' => 'nullable|exists:kegiatan,id',
        ]);

        $galeri = Galeri::findOrFail($id);
        
        $data = $request->except('file_foto');

        if ($request->hasFile('file_foto')) {

            if (Storage::disk('public')->exists($galeri->file_foto)) {
                Storage::disk('public')->delete($galeri->file_foto);
            }

            $data['file_foto'] = $request->file('file_foto')->store('galeri', 'public');
        }

        $galeri->update($data);

        return redirect()->back()->with('sukses', 'Data galeri berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $this->checkSuperAdmin();
        
        $galeri = Galeri::findOrFail($id);
        
        if (Storage::disk('public')->exists($galeri->file_foto)) {
            Storage::disk('public')->delete($galeri->file_foto);
        }
        
        $galeri->delete();

        return redirect()->back()->with('sukses', 'Foto galeri berhasil dihapus!');
    }
}
