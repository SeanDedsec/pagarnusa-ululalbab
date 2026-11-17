<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Keuangan;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    public function index()
    {
        $keuangan = Keuangan::orderBy('tanggal', 'desc')->orderBy('waktu', 'desc')->get();

        $totalMasuk = Keuangan::where('jenis_transaksi', 'masuk')->sum('nominal');
        $totalKeluar = Keuangan::where('jenis_transaksi', 'keluar')->sum('nominal');
        $saldo = $totalMasuk - $totalKeluar;

        return view('admin.pages.transactions', compact('keuangan', 'totalMasuk', 'totalKeluar', 'saldo'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'waktu' => 'required|date_format:H:i:s',
            'jenis_transaksi' => 'required|in:masuk,keluar',
            'kategori' => 'required|string|max:255',
            'nominal' => 'required|numeric|min:1',
            'keterangan' => 'nullable|string',
        ]);

        Keuangan::create([
            'tanggal' => $request->tanggal,
            'waktu' => $request->waktu,
            'jenis_transaksi' => $request->jenis_transaksi,
            'kategori' => $request->kategori,
            'nominal' => $request->nominal,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->back()->with('sukses', 'Transaksi berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'waktu' => 'required|date_format:H:i:s',
            'jenis_transaksi' => 'required|in:masuk,keluar',
            'kategori' => 'required|string|max:255',
            'nominal' => 'required|numeric|min:1',
            'keterangan' => 'nullable|string',
        ]);

        $keuangan = Keuangan::findOrFail($id);
        
        $keuangan->update([
            'tanggal' => $request->tanggal,
            'waktu' => $request->waktu,
            'jenis_transaksi' => $request->jenis_transaksi,
            'kategori' => $request->kategori,
            'nominal' => $request->nominal,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->back()->with('sukses', 'Transaksi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $keuangan = Keuangan::findOrFail($id);
        $keuangan->delete();

        return redirect()->back()->with('sukses', 'Transaksi berhasil dihapus!');
    }

    public function cetakPdf(Request $request)
    {
        $keuangan = Keuangan::orderBy('tanggal', 'desc')->orderBy('waktu', 'desc')->get();
        $totalMasuk = Keuangan::where('jenis_transaksi', 'masuk')->sum('nominal');
        $totalKeluar = Keuangan::where('jenis_transaksi', 'keluar')->sum('nominal');
        $saldo = $totalMasuk - $totalKeluar;

        $tanggal_mulai = $request->input('tanggal_mulai', date('Y-m-01'));
        $tanggal_akhir = $request->input('tanggal_akhir', date('Y-m-d'));

        $pdf = Pdf::loadView('pdf.report', compact('keuangan', 'totalMasuk', 'totalKeluar', 'saldo', 'tanggal_mulai', 'tanggal_akhir'));
        
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('Laporan_Keuangan_PagarNusa.pdf');
    }
}