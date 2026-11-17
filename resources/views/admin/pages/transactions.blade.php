@extends('admin.layouts.app')

@section('content')
    <style>
        /* ---------- Kelola Keuangan ---------- */
        .keu-judul { font-size: clamp(1.4rem, 4vw, 1.8rem); margin: 0; }
        .keu-aksi .btn { padding: 10px 18px; }
        .keu-aksi .btn-success { background: #1d6b4f; border-color: #1d6b4f; }
        .keu-aksi .btn-success:hover { background: #0f3d2e; border-color: #0f3d2e; }
        @media (max-width: 575.98px) {
            .keu-aksi { width: 100%; display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
            .keu-aksi .btn { margin: 0 !important; width: 100%; }
        }

        /* Kartu ringkasan */
        .ringkas {
            background: #fff; border: 1px solid #dbe5df; border-radius: 14px;
            padding: 18px 20px; height: 100%;
            display: flex; align-items: center; gap: 16px;
            border-left-width: 5px;
        }
        .ringkas .ikon { width: 46px; height: 46px; border-radius: 12px; display: grid; place-items: center; font-size: 1.15rem; flex-shrink: 0; }
        .ringkas h6 { margin: 0 0 2px; font-size: .86rem; font-weight: 600; color: #5d6b64; }
        .ringkas .angka { margin: 0; font-family: 'Fraunces', serif; font-weight: 700; font-size: 1.45rem; font-variant-numeric: tabular-nums; line-height: 1.2; }
        .ringkas.masuk { border-left-color: #1d6b4f; }
        .ringkas.masuk .ikon { background: #e8f1ec; color: #1d6b4f; }
        .ringkas.masuk .angka { color: #1d6b4f; }
        .ringkas.keluar { border-left-color: #b3322b; }
        .ringkas.keluar .ikon { background: #fbeceb; color: #b3322b; }
        .ringkas.keluar .angka { color: #b3322b; }
        .ringkas.saldo { background: #0f3d2e; border-color: #0f3d2e; border-left-color: #c9a227; }
        .ringkas.saldo .ikon { background: rgba(201,162,39,.18); color: #c9a227; }
        .ringkas.saldo h6 { color: rgba(255,255,255,.75); }
        .ringkas.saldo .angka { color: #c9a227; }

        /* Tabel */
        .keu-tabel td.nominal { font-weight: 700; font-variant-numeric: tabular-nums; white-space: nowrap; }
        .keu-tabel td.nominal.masuk { color: #1d6b4f; }
        .keu-tabel td.nominal.keluar { color: #b3322b; }
        .keu-tabel .badge.bg-success { background: #e8f1ec !important; color: #0f3d2e; }
        .keu-tabel .badge.bg-danger { background: #fbeceb !important; color: #8f2620; }
        .keu-tabel .btn-aksi { width: 38px; height: 38px; padding: 0; display: inline-grid; place-items: center; }
        .keu-kosong { padding: 36px 12px !important; color: #5d6b64; }

        /* Tabel jadi kartu di HP */
        @media (max-width: 767.98px) {
            .keu-tabel thead { display: none; }
            .keu-tabel, .keu-tabel tbody, .keu-tabel tr, .keu-tabel td { display: block; width: 100%; }
            .keu-tabel tbody tr { border: 1px solid #dbe5df; border-radius: 12px; margin-bottom: 12px; padding: 6px 14px; background: #fff; }
            .keu-tabel td { display: flex; justify-content: space-between; align-items: center; gap: 16px; padding: 9px 0 !important; border: 0; border-bottom: 1px dashed #e3ebe6; text-align: right; }
            .keu-tabel td:last-child { border-bottom: 0; }
            .keu-tabel td::before { content: attr(data-label); font-size: .8rem; font-weight: 600; color: #5d6b64; text-align: left; flex-shrink: 0; }
            .keu-tabel td.keu-kosong { display: block; text-align: center; }
            .keu-tabel td.keu-kosong::before { content: none; }
            .keu-tabel td.aksi { justify-content: flex-end; gap: 6px; }
            .keu-tabel td.aksi::before { content: none; }
            .keu-card-tabel .card-body { padding: 12px; background: transparent; }
            .keu-card-tabel { background: transparent !important; border: 0 !important; }
        }

        /* Modal */
        .keu-modal .modal-content { border: 0; border-radius: 18px; overflow: hidden; }
        .keu-modal .modal-header { border-bottom: 1px solid #dbe5df; padding: 18px 22px; }
        .keu-modal .modal-title { font-family: 'Fraunces', serif; font-weight: 700; color: #0f3d2e; font-size: 1.2rem; }
        .keu-modal .modal-body { padding: 20px 22px; }
        .keu-modal .modal-footer { border-top: 1px solid #dbe5df; background: #f4f7f5; padding: 14px 22px; }
        .keu-modal .form-control, .keu-modal .form-select { font-size: 1rem; padding: 11px 13px; }
        .keu-modal .btn { border-radius: 999px; padding: 9px 22px; font-weight: 600; }
        .keu-modal .btn-success { background: #1d6b4f; border-color: #1d6b4f; }
        .keu-modal .btn-success:hover { background: #0f3d2e; border-color: #0f3d2e; }
        .ikon-hapus { width: 56px; height: 56px; border-radius: 50%; background: #fbeceb; color: #b3322b; display: grid; place-items: center; font-size: 1.4rem; margin: 0 auto 14px; }
    </style>

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <h2 class="fw-bold keu-judul" style="color: var(--hijau-tua);">Kelola Keuangan</h2>
        <div class="keu-aksi">
            <a href="/admin/keuangan/cetak-pdf" class="btn btn-danger me-2" target="_blank">
                <i class="fas fa-file-pdf"></i> Cetak PDF
            </a>

            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambahKeuangan">
                <i class="fas fa-plus"></i> Catat Transaksi
            </button>
        </div>
    </div>

    @if(session('sukses'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('sukses') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="ringkas masuk">
                <div class="ikon"><i class="fas fa-arrow-down"></i></div>
                <div>
                    <h6>Total Pemasukan</h6>
                    <p class="angka">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="ringkas keluar">
                <div class="ikon"><i class="fas fa-arrow-up"></i></div>
                <div>
                    <h6>Total Pengeluaran</h6>
                    <p class="angka">Rp {{ number_format($totalKeluar, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="ringkas saldo">
                <div class="ikon"><i class="fas fa-wallet"></i></div>
                <div>
                    <h6>Saldo Akhir</h6>
                    <p class="angka">Rp {{ number_format($saldo, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm keu-card-tabel">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle keu-tabel mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal & Waktu</th> <!-- DIGABUNG -->
                        <th>Kategori</th>
                        <th>Jenis</th>
                        <th>Nominal</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($keuangan as $k)
                    <tr>
                        <td data-label="Waktu">
                            {{ \Carbon\Carbon::parse($k->tanggal)->format('d M Y') }} <br>
                            <small class="text-muted"><i class="far fa-clock"></i> {{ $k->waktu ? \Carbon\Carbon::parse($k->waktu)->format('H:i:s') : '--:--:--' }}</small>
                        </td>
                        <td data-label="Kategori">{{ $k->kategori }}</td>
                        <td data-label="Jenis">
                            @if($k->jenis_transaksi == 'masuk')
                                <span class="badge bg-success">Masuk</span>
                            @else
                                <span class="badge bg-danger">Keluar</span>
                            @endif
                        </td>
                        <td data-label="Nominal" class="nominal {{ $k->jenis_transaksi == 'masuk' ? 'masuk' : 'keluar' }}">Rp {{ number_format($k->nominal, 0, ',', '.') }}</td>
                        <td data-label="Keterangan">{{ $k->keterangan ?? '-' }}</td>
                        <td class="aksi">
                            <!-- Tombol Edit -->
                            <button class="btn btn-sm btn-primary btn-aksi me-1" data-bs-toggle="modal" data-bs-target="#modalEditKeuangan"
                                data-id="{{ $k->id }}"
                                data-tanggal="{{ $k->tanggal }}"
                                data-waktu="{{ $k->waktu }}"
                                data-jenis="{{ $k->jenis_transaksi }}"
                                data-kategori="{{ $k->kategori }}"
                                data-nominal="{{ $k->nominal }}"
                                data-keterangan="{{ $k->keterangan }}" aria-label="Edit transaksi {{ $k->kategori }}">
                                <i class="fas fa-edit"></i>
                            </button>

                            <!-- Tombol Hapus -->
                            <button class="btn btn-sm btn-danger btn-aksi" data-bs-toggle="modal" data-bs-target="#modalHapusKeuangan"
                                data-id="{{ $k->id }}"
                                data-kategori="{{ $k->kategori }}" aria-label="Hapus transaksi {{ $k->kategori }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center keu-kosong">Belum ada data transaksi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL TAMBAH -->
    <div class="modal fade keu-modal" id="modalTambahKeuangan" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form action="/admin/keuangan" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Catat Transaksi Manual</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label" for="k_tanggal">Tanggal</label>
                                <input type="date" id="k_tanggal" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label" for="k_waktu">Waktu</label>
                                <!-- step="1" agar muncul detik -->
                                <input type="time" id="k_waktu" name="waktu" class="form-control" value="{{ date('H:i:s') }}" step="1" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="k_jenis">Jenis Transaksi</label>
                            <select id="k_jenis" name="jenis_transaksi" class="form-select" required>
                                <option value="masuk">Uang Masuk (Pemasukan)</option>
                                <option value="keluar">Uang Keluar (Pengeluaran)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="k_kategori">Kategori</label>
                            <input type="text" id="k_kategori" name="kategori" class="form-control" placeholder="Contoh: Beli Air Minum, Donasi" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="k_nominal">Nominal (Rp)</label>
                            <input type="number" id="k_nominal" name="nominal" class="form-control" inputmode="numeric" placeholder="Contoh: 15000" required>
                        </div>
                        <div class="mb-1">
                            <label class="form-label" for="k_ket">Keterangan (Opsional)</label>
                            <textarea id="k_ket" name="keterangan" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan Transaksi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL EDIT -->
    <div class="modal fade keu-modal" id="modalEditKeuangan" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form id="formEditKeuangan" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Transaksi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label" for="e_tanggal">Tanggal</label>
                                <input type="date" id="e_tanggal" name="tanggal" class="form-control" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label" for="e_waktu">Waktu</label>
                                <input type="time" id="e_waktu" name="waktu" class="form-control" step="1" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="e_jenis">Jenis Transaksi</label>
                            <select id="e_jenis" name="jenis_transaksi" class="form-select" required>
                                <option value="masuk">Uang Masuk (Pemasukan)</option>
                                <option value="keluar">Uang Keluar (Pengeluaran)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="e_kategori">Kategori</label>
                            <input type="text" id="e_kategori" name="kategori" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="e_nominal">Nominal (Rp)</label>
                            <input type="number" id="e_nominal" name="nominal" class="form-control" inputmode="numeric" required>
                        </div>
                        <div class="mb-1">
                            <label class="form-label" for="e_ket">Keterangan (Opsional)</label>
                            <textarea id="e_ket" name="keterangan" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Update Transaksi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL HAPUS -->
    <div class="modal fade keu-modal" id="modalHapusKeuangan" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="formHapusKeuangan" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body text-center">
                        <div class="ikon-hapus"><i class="fas fa-trash-can"></i></div>
                        <p>Apakah Anda yakin ingin menghapus transaksi kategori <strong id="hapus_kategori"></strong>?</p>
                        <small class="text-danger">*Catatan: Jika ini adalah transaksi Kas Latihan, menghapusnya tidak akan menghapus data absensi siswa, namun saldo akan berkurang.</small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        
        // SCRIPT UNTUK MODAL EDIT
        var modalEditKeuangan = document.getElementById('modalEditKeuangan');
        modalEditKeuangan.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var tanggal = button.getAttribute('data-tanggal');
            var waktu = button.getAttribute('data-waktu');
            var jenis = button.getAttribute('data-jenis');
            var kategori = button.getAttribute('data-kategori');
            var nominal = button.getAttribute('data-nominal');
            var keterangan = button.getAttribute('data-keterangan');

            document.getElementById('formEditKeuangan').action = '/admin/keuangan/' + id;
            document.getElementById('e_tanggal').value = tanggal;
            document.getElementById('e_waktu').value = waktu;
            document.getElementById('e_jenis').value = jenis;
            document.getElementById('e_kategori').value = kategori;
            document.getElementById('e_nominal').value = nominal;
            document.getElementById('e_ket').value = keterangan;
        });

        // SCRIPT UNTUK MODAL HAPUS
        var modalHapusKeuangan = document.getElementById('modalHapusKeuangan');
        modalHapusKeuangan.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var kategori = button.getAttribute('data-kategori');

            document.getElementById('formHapusKeuangan').action = '/admin/keuangan/' + id;
            document.getElementById('hapus_kategori').textContent = kategori;
        });
    });
</script>
@endpush