<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Keuangan;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    /**
     * Terapkan filter (kategori, jenis, rentang tanggal) ke query.
     * Dipakai bersama oleh halaman daftar dan cetak PDF agar hasilnya selalu sama.
     */
    private function terapkanFilter(Request $request)
    {
        $query = Keuangan::query();

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('jenis') && in_array($request->jenis, ['masuk', 'keluar'])) {
            $query->where('jenis_transaksi', $request->jenis);
        }

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_akhir);
        }

        return $query;
    }

    public function index(Request $request)
    {
        // after_or_equal hanya dipasang kalau tanggal mulai diisi
        $aturanAkhir = ['nullable', 'date'];
        if ($request->filled('tanggal_mulai')) {
            $aturanAkhir[] = 'after_or_equal:tanggal_mulai';
        }

        $request->validate([
            'kategori'      => 'nullable|string|max:255',
            'jenis'         => 'nullable|in:masuk,keluar',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_akhir' => $aturanAkhir,
        ], [
            'tanggal_akhir.after_or_equal' => 'Tanggal akhir tidak boleh lebih awal dari tanggal mulai.',
        ]);

        $query = $this->terapkanFilter($request);

        // UBAH URUTAN MENJADI DESC (Terbaru ke Terlama)
        $keuangan = (clone $query)
            ->orderBy('tanggal', 'desc')
            ->orderBy('waktu', 'desc')
            ->paginate(10)
            ->withQueryString();

        // Kartu ringkasan tetap menampilkan total keseluruhan (tidak terpengaruh filter)
        $totalMasuk = Keuangan::where('jenis_transaksi', 'masuk')->sum('nominal');
        $totalKeluar = Keuangan::where('jenis_transaksi', 'keluar')->sum('nominal');
        $saldo = $totalMasuk - $totalKeluar;

        // Total khusus hasil filter
        $filterMasuk = (clone $query)->where('jenis_transaksi', 'masuk')->sum('nominal');
        $filterKeluar = (clone $query)->where('jenis_transaksi', 'keluar')->sum('nominal');

        // Daftar kategori untuk pilihan filter
        $daftarKategori = Keuangan::select('kategori')
            ->whereNotNull('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        return view('admin.pages.transactions', compact(
            'keuangan', 'totalMasuk', 'totalKeluar', 'saldo',
            'filterMasuk', 'filterKeluar', 'daftarKategori'
        ));
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
        // PDF mengikuti filter yang sedang aktif di halaman
        $query = $this->terapkanFilter($request);

        // UBAH URUTAN MENJADI DESC (Terbaru ke Terlama)
        $keuangan = (clone $query)->orderBy('tanggal', 'desc')->orderBy('waktu', 'desc')->get();
        $totalMasuk = (clone $query)->where('jenis_transaksi', 'masuk')->sum('nominal');
        $totalKeluar = (clone $query)->where('jenis_transaksi', 'keluar')->sum('nominal');
        $saldo = $totalMasuk - $totalKeluar;

        $tanggal_mulai = $request->input('tanggal_mulai', date('Y-m-01'));
        $tanggal_akhir = $request->input('tanggal_akhir', date('Y-m-d'));

        $pdf = Pdf::loadView('pdf.report', compact('keuangan', 'totalMasuk', 'totalKeluar', 'saldo', 'tanggal_mulai', 'tanggal_akhir'));
        
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('Laporan_Keuangan_PagarNusa.pdf');
    }
}