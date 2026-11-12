<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Keuangan;

class TransactionController extends Controller
{
    public function index()
    {
        $keuangan = Keuangan::orderBy('tanggal', 'desc')->get();

        $totalMasuk = Keuangan::where('jenis_transaksi', 'masuk')->sum('nominal');
        $totalKeluar = Keuangan::where('jenis_transaksi', 'keluar')->sum('nominal');
        $saldo = $totalMasuk - $totalKeluar;

        return view('admin.pages.transactions', compact('keuangan', 'totalMasuk', 'totalKeluar', 'saldo'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jenis_transaksi' => 'required|in:masuk,keluar',
            'kategori' => 'required|string|max:255',
            'nominal' => 'required|numeric|min:1',
            'keterangan' => 'nullable|string',
        ]);

        Keuangan::create([
            'tanggal' => $request->tanggal,
            'jenis_transaksi' => $request->jenis_transaksi,
            'kategori' => $request->kategori,
            'nominal' => $request->nominal,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->back()->with('sukses', 'Transaksi berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $keuangan = Keuangan::findOrFail($id);
        $keuangan->delete();

        return redirect()->back()->with('sukses', 'Transaksi berhasil dihapus!');
    }
}