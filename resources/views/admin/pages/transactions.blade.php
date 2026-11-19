@extends('admin.layouts.app')

@section('content')
    @php
        // Hitung filter yang benar-benar terisi (kolom kosong tidak dihitung)
        $jumlahFilter = collect(['kategori', 'jenis', 'tanggal_mulai', 'tanggal_akhir'])
            ->filter(fn($f) => request()->filled($f))->count();
        $queryCetak = http_build_query(request()->except('page'));
    @endphp

    <style>
        /* ---------- Kelola Keuangan ---------- */
        .keu-judul { font-size: clamp(1.3rem, 4vw, 1.8rem); margin: 0; }
        .keu-aksi .btn { padding: 10px 15px; font-size: 0.9rem; }
        .keu-aksi .btn-success { background: #1d6b4f; border-color: #1d6b4f; }
        .keu-aksi .btn-success:hover { background: #0f3d2e; border-color: #0f3d2e; }

        @media (max-width: 575.98px) {
            .keu-aksi { width: 100%; display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
            .keu-aksi .btn { margin: 0 !important; width: 100%; }
        }

        /* Kartu ringkasan */
        .ringkas {
            background: #fff; border: 1px solid #dbe5df; border-radius: 14px;
            padding: 15px; height: 100%;
            display: flex; align-items: center; gap: 12px;
            border-left-width: 5px;
        }
        .ringkas .ikon { width: 40px; height: 40px; border-radius: 10px; display: grid; place-items: center; font-size: 1rem; flex-shrink: 0; }
        .ringkas h6 { margin: 0 0 2px; font-size: .8rem; font-weight: 600; color: #5d6b64; }
        .ringkas .angka { margin: 0; font-family: 'Fraunces', serif; font-weight: 700; font-size: 1.2rem; font-variant-numeric: tabular-nums; line-height: 1.2; }

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

        /* ---------- Filter ---------- */
        .keu-filter-toggle {
            display: flex; align-items: center; gap: 10px; justify-content: center;
            background: #fff; border: 1.5px solid #dbe5df; color: #0f3d2e; font-weight: 600;
            border-radius: 12px; padding: 12px;
        }
        .keu-filter-toggle:hover { background: #e8f1ec; color: #0f3d2e; }
        .keu-filter-toggle .jml { background: #1d6b4f; color: #fff; border-radius: 999px; font-size: .75rem; padding: 2px 9px; }
        .keu-filter-toggle .panah { transition: transform .2s; margin-left: auto; }
        .keu-filter-toggle[aria-expanded="true"] .panah { transform: rotate(180deg); }

        .keu-filter { background: #fff; border: 1px solid #dbe5df !important; border-radius: 14px; }
        .keu-filter .form-label { font-size: .85rem; margin-bottom: 5px; }
        .keu-filter .form-control, .keu-filter .form-select { font-size: 1rem; padding: 11px 13px; }
        .keu-filter .btn { padding: 11px; }

        .keu-hasil { font-size: .88rem; color: #5d6b64; margin: 0 2px 10px; display: flex; flex-wrap: wrap; gap: 4px 14px; align-items: center; }
        .keu-hasil b.masuk { color: #1d6b4f; }
        .keu-hasil b.keluar { color: #b3322b; }

        /* Tabel */
        .keu-tabel td.nominal { font-weight: 700; font-variant-numeric: tabular-nums; white-space: nowrap; }
        .keu-tabel td.nominal.masuk { color: #1d6b4f; }
        .keu-tabel td.nominal.keluar { color: #b3322b; }
        .keu-tabel .badge { padding: .45em .8em; border-radius: 999px; }
        .keu-tabel .badge.bg-success { background: #e8f1ec !important; color: #0f3d2e; }
        .keu-tabel .badge.bg-danger { background: #fbeceb !important; color: #8f2620; }
        .keu-tabel .btn-aksi { width: 38px; height: 38px; padding: 0; display: inline-grid; place-items: center; font-size: 0.9rem; border-radius: 10px; }
        .keu-kosong { padding: 36px 12px !important; color: #5d6b64; }

        /* ---------- Tampilan Tabel di HP (Mobile) ---------- */
        @media (max-width: 767.98px) {
            /* Paksa tabel tetap berupa tabel dan bisa di-scroll */
            .keu-card-tabel .card-body { padding: 10px; }
            .keu-tabel { min-width: 850px; /* Sedikit dilebarkan agar kolom No muat */ }
            
            .keu-tabel th, .keu-tabel td {
                font-size: 0.8rem; /* Perkecil font */
                padding: 8px 6px !important;
                white-space: nowrap; /* Cegah teks turun ke bawah */
            }
            
            .keu-tabel .btn-aksi { width: 30px; height: 30px; font-size: 0.75rem; }
            .keu-tabel .badge { font-size: 0.7rem; padding: 0.3em 0.6em; }
            
            /* KOLOM NO SUDAH DIMUNCULKAN KEMBALI */
            /* .keu-tabel th:first-child, .keu-tabel td:first-child { display: none; } */
        }

        /* ---------- Navigasi halaman (Sebelumnya / Berikutnya) ---------- */
        .keu-pager { display: grid; grid-template-columns: 1fr auto 1fr; align-items: center; gap: 10px; padding: 14px 16px; }
        .keu-pager .info { text-align: center; font-weight: 600; color: #0f3d2e; line-height: 1.25; font-size: .92rem; }
        .keu-pager .info small { display: block; font-weight: 500; color: #5d6b64; font-size: .78rem; }
        .btn-pager {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            min-height: 44px; padding: 0 16px; border-radius: 999px; font-weight: 600; text-decoration: none;
            background: #1d6b4f; color: #fff; border: 0;
        }
        .btn-pager:hover { background: #0f3d2e; color: #fff; }
        .btn-pager.nonaktif { background: #eceff0; color: #9aa6a0; pointer-events: none; }
        .keu-pager .kiri { justify-self: start; }
        .keu-pager .kanan { justify-self: end; }
        @media (max-width: 575.98px) {
            .keu-pager { grid-template-columns: 1fr 1fr; padding: 12px 0 0; }
            .keu-pager .info { grid-column: 1 / -1; order: -1; }
            .keu-pager .kiri, .keu-pager .kanan { justify-self: stretch; }
            .keu-card-tabel .keu-pager-wrap { background: transparent !important; }
        }

        /* Modal */
        .keu-modal .modal-content { border: 0; border-radius: 18px; overflow: hidden; }
        .keu-modal .modal-header { border-bottom: 1px solid #dbe5df; padding: 15px 20px; }
        .keu-modal .modal-title { font-family: 'Fraunces', serif; font-weight: 700; color: #0f3d2e; font-size: 1.15rem; }
        .keu-modal .modal-body { padding: 20px; }
        .keu-modal .modal-footer { border-top: 1px solid #dbe5df; background: #f4f7f5; padding: 12px 20px; }
        .keu-modal .form-control, .keu-modal .form-select { font-size: 1rem; padding: 10px 13px; }
        .keu-modal .btn { border-radius: 999px; padding: 8px 20px; font-weight: 600; }
        .keu-modal .btn-success { background: #1d6b4f; border-color: #1d6b4f; }
        .keu-modal .btn-success:hover { background: #0f3d2e; border-color: #0f3d2e; }
        .ikon-hapus { width: 50px; height: 50px; border-radius: 50%; background: #fbeceb; color: #b3322b; display: grid; place-items: center; font-size: 1.3rem; margin: 0 auto 14px; }
    </style>

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <h2 class="fw-bold keu-judul" style="color: var(--hijau-tua);">Kelola Keuangan</h2>
        <div class="keu-aksi">
            <a href="/admin/keuangan/cetak-pdf{{ $queryCetak ? '?' . $queryCetak : '' }}" class="btn btn-danger me-2" target="_blank">
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

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            {{ $errors->first() }}
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

    <!-- FILTER -->
    <button class="btn keu-filter-toggle d-md-none w-100 mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#panelFilter" aria-expanded="{{ $jumlahFilter ? 'true' : 'false' }}" aria-controls="panelFilter">
        <i class="fas fa-filter"></i> Filter transaksi
        @if($jumlahFilter)<span class="jml">{{ $jumlahFilter }}</span>@endif
        <i class="fas fa-chevron-down panah"></i>
    </button>

    <div class="collapse d-md-block {{ $jumlahFilter ? 'show' : '' }}" id="panelFilter">
        <div class="card border-0 shadow-sm mb-3 keu-filter">
            <div class="card-body">
                <form action="/admin/keuangan" method="GET" class="row g-3 align-items-end">
                    <div class="col-12 col-lg-3">
                        <label class="form-label" for="f_kategori">Kategori</label>
                        <select id="f_kategori" name="kategori" class="form-select">
                            <option value="">Semua Kategori</option>
                            @foreach($daftarKategori as $kat)
                                <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-6 col-lg-2">
                        <label class="form-label" for="f_jenis">Jenis</label>
                        <select id="f_jenis" name="jenis" class="form-select">
                            <option value="">Semua Jenis</option>
                            <option value="masuk" {{ request('jenis') == 'masuk' ? 'selected' : '' }}>Pemasukan</option>
                            <option value="keluar" {{ request('jenis') == 'keluar' ? 'selected' : '' }}>Pengeluaran</option>
                        </select>
                    </div>
                    <div class="col-6 col-md-3 col-lg-2">
                        <label class="form-label" for="f_mulai">Tanggal Mulai</label>
                        <input type="date" id="f_mulai" name="tanggal_mulai" class="form-control" value="{{ request('tanggal_mulai') }}">
                    </div>
                    <div class="col-6 col-md-3 col-lg-2">
                        <label class="form-label" for="f_akhir">Tanggal Akhir</label>
                        <input type="date" id="f_akhir" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                    </div>
                    <div class="col-12 col-lg-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1"><i class="fas fa-search"></i> Terapkan</button>
                        @if($jumlahFilter)
                            <a href="/admin/keuangan" class="btn btn-outline-secondary" aria-label="Hapus semua filter"><i class="fas fa-rotate-left"></i> Reset</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Ringkasan hasil -->
    <p class="keu-hasil">
        @if($keuangan->total() > 0)
            <span>Menampilkan {{ $keuangan->firstItem() }}-{{ $keuangan->lastItem() }} dari <b>{{ $keuangan->total() }}</b> transaksi</span>
        @endif
        @if($jumlahFilter && $keuangan->total() > 0)
            <span>Masuk <b class="masuk">Rp {{ number_format($filterMasuk, 0, ',', '.') }}</b></span>
            <span>Keluar <b class="keluar">Rp {{ number_format($filterKeluar, 0, ',', '.') }}</b></span>
        @endif
    </p>

    <div class="card border-0 shadow-sm keu-card-tabel">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle keu-tabel mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th> <!-- KOLOM NO -->
                        <th>Tanggal & Waktu</th>
                        <th>Kategori</th>
                        <th>Jenis</th>
                        <th>Nominal</th>
                        <th>Keterangan</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($keuangan as $index => $k)
                    <tr>
                        <!-- Penomoran otomatis lanjut antar halaman -->
                        <td class="no">{{ $keuangan->firstItem() + $index }}</td>

                        <td>
                            <div class="fw-bold">{{ \Carbon\Carbon::parse($k->tanggal)->format('d M Y') }}</div>
                            <small class="text-muted"><i class="far fa-clock"></i> {{ $k->waktu ? \Carbon\Carbon::parse($k->waktu)->format('H:i:s') : '--:--:--' }}</small>
                        </td>
                        <td>{{ $k->kategori }}</td>
                        <td>
                            @if($k->jenis_transaksi == 'masuk')
                                <span class="badge bg-success">Masuk</span>
                            @else
                                <span class="badge bg-danger">Keluar</span>
                            @endif
                        </td>
                        <td class="nominal {{ $k->jenis_transaksi == 'masuk' ? 'masuk' : 'keluar' }}">Rp {{ number_format($k->nominal, 0, ',', '.') }}</td>
                        <td>
                            <span style="font-size: 0.9rem;">{{ $k->keterangan ?? '-' }}</span>
                        </td>
                        <td class="aksi">
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

                            <button class="btn btn-sm btn-danger btn-aksi" data-bs-toggle="modal" data-bs-target="#modalHapusKeuangan"
                                data-id="{{ $k->id }}"
                                data-kategori="{{ $k->kategori }}" aria-label="Hapus transaksi {{ $k->kategori }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center keu-kosong">
                            {{ $jumlahFilter ? 'Tidak ada transaksi yang cocok dengan filter.' : 'Belum ada data transaksi.' }}
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION (Sebelumnya / Berikutnya) -->
        @if($keuangan->hasPages())
        <div class="card-footer bg-white border-top-0 keu-pager-wrap">
            <div class="keu-pager">
                @if($keuangan->onFirstPage())
                    <span class="btn-pager nonaktif kiri" aria-disabled="true"><i class="fas fa-chevron-left"></i> Sebelumnya</span>
                @else
                    <a class="btn-pager kiri" href="{{ $keuangan->previousPageUrl() }}" rel="prev"><i class="fas fa-chevron-left"></i> Sebelumnya</a>
                @endif

                <div class="info">
                    Halaman {{ $keuangan->currentPage() }} dari {{ $keuangan->lastPage() }}
                    <small>{{ $keuangan->total() }} transaksi</small>
                </div>

                @if($keuangan->hasMorePages())
                    <a class="btn-pager kanan" href="{{ $keuangan->nextPageUrl() }}" rel="next">Berikutnya <i class="fas fa-chevron-right"></i></a>
                @else
                    <span class="btn-pager nonaktif kanan" aria-disabled="true">Berikutnya <i class="fas fa-chevron-right"></i></span>
                @endif
            </div>
        </div>
        @endif
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