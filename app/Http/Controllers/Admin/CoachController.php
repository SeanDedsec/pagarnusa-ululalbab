<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pelatih;

class CoachController extends Controller
{
    public function index()
    {
        $pelatih = Pelatih::orderBy('created_at', 'desc')->get();
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
