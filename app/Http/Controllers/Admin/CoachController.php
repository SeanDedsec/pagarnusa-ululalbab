<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pelatih;

class CoachController extends Controller
{
    public function index(Request $request)
    {
        // Mulai query
        $query = Pelatih::orderBy('created_at', 'desc');

        // Filter berdasarkan Nama Pelatih
        if ($request->filled('nama')) {
            $query->where('nama_pelatih', 'like', '%' . $request->nama . '%');
        }

        // Filter berdasarkan Alamat
        if ($request->filled('alamat')) {
            $query->where('alamat', 'like', '%' . $request->alamat . '%');
        }

        // Ambil data hasil filter
        $pelatih = $query->get();
        
        return view('admin.pages.coaches', compact('pelatih'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pelatih' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_hp' => 'required|numeric',
        ]);

        Pelatih::create([
            'nama_pelatih' => $request->nama_pelatih,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
        ]);

        return redirect()->back()->with('sukses', 'Data pelatih berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pelatih' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_hp' => 'required|numeric',
        ]);

        $pelatih = Pelatih::findOrFail($id);
        $pelatih->update($request->all());

        return redirect()->back()->with('sukses', 'Data pelatih berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pelatih = Pelatih::findOrFail($id);
        $pelatih->delete();

        return redirect()->back()->with('sukses', 'Data pelatih berhasil dihapus!');
    }
}