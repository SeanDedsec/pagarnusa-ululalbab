@extends('admin.layouts.app')

@section('content')
    @php
        // Hitung filter yang terisi
        $jumlahFilter = collect(['nama', 'alamat'])->filter(fn($f) => request()->filled($f))->count();
    @endphp

    <style>
        /* ---------- Optimasi Ketajaman Teks ---------- */
        .pl-judul, .pl-tabel, .pl-modal, .pl-filter {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
        }

        /* ---------- Data Pelatih ---------- */
        .pl-judul { font-size: clamp(1.3rem, 4vw, 1.8rem); margin: 0; letter-spacing: -0.5px; }
        .pl-tambah { background: #1d6b4f; border-color: #1d6b4f; padding: 10px 18px; font-weight: 600; }
        .pl-tambah:hover { background: #0f3d2e; border-color: #0f3d2e; }
        
        @media (max-width: 575.98px) {
            .pl-tambah { width: 100%; }
        }

        /* Filter */
        .pl-filter-toggle {
            display: flex; align-items: center; gap: 10px; justify-content: center;
            background: #fff; border: 1.5px solid #dbe5df; color: #0f3d2e; font-weight: 600;
            border-radius: 12px; padding: 12px; margin-bottom: 10px;
        }
        .pl-filter-toggle:hover { background: #e8f1ec; color: #0f3d2e; }
        .pl-filter-toggle .jml { background: #1d6b4f; color: #fff; border-radius: 999px; font-size: .75rem; padding: 2px 9px; font-weight: 700; }
        .pl-filter-toggle .panah { transition: transform .2s; margin-left: auto; }
        .pl-filter-toggle[aria-expanded="true"] .panah { transform: rotate(180deg); }

        .pl-filter { background: #fff; border: 1px solid #dbe5df !important; border-radius: 14px; }
        .pl-filter .form-label { font-size: .85rem; font-weight: 600; margin-bottom: 5px; }
        .pl-filter .form-control, .pl-filter .form-select { font-size: 0.95rem; padding: 11px 13px; font-weight: 500; }
        .pl-filter .btn-primary { padding: 11px; font-weight: 600; }
        .pl-reset { display: inline-block; margin-top: 8px; font-size: .88rem; font-weight: 600; color: #5d6b64; text-decoration: none; }
        .pl-reset:hover { color: #b3322b; }

        /* Tabel Utama */
        .pl-tabel .nama-sel { display: flex; align-items: center; gap: 10px; font-weight: 600; color: #0f3d2e; }
        .pl-avatar { width: 34px; height: 34px; border-radius: 50%; background: #e8f1ec; color: #1d6b4f; display: grid; place-items: center; font-weight: 700; font-size: .85rem; flex-shrink: 0; }
        
        .pl-tabel th { font-weight: 700; color: #16241d; font-size: 0.85rem; letter-spacing: 0.3px; }
        .pl-tabel td { font-weight: 500; color: #333; font-size: 0.9rem; }
        
        /* Tombol Aksi */
        .pl-tabel .aksi-grup { 
            display: flex; 
            flex-direction: row; /* Memastikan sejajar ke samping */
            flex-wrap: nowrap; /* Mencegah turun ke bawah */
            gap: 6px; 
            align-items: center;
        }
        .pl-tabel .btn-ikon { width: 36px; height: 36px; padding: 0; display: inline-grid; place-items: center; border-radius: 8px; flex-shrink: 0; }
        .pl-kosong { padding: 36px 12px !important; color: #5d6b64; font-weight: 500; }

        /* ---------- Tampilan Tabel di HP (Mobile) ---------- */
        @media (max-width: 767.98px) {
            .pl-card-tabel .card-body { padding: 10px; }
            .pl-tabel { min-width: 650px; /* Paksa tabel bisa di-scroll horizontal */ }
            
            .pl-tabel th, .pl-tabel td {
                font-size: 0.8rem; 
                padding: 8px 6px !important;
                white-space: nowrap;
            }
            
            .pl-tabel .pl-avatar { width: 28px; height: 28px; font-size: 0.75rem; margin-right: 2px; }
            .pl-tabel .btn-ikon { width: 32px; height: 32px; font-size: 0.75rem; }
            .pl-tabel .aksi-grup { gap: 4px; }
        }

        /* Modal */
        .pl-modal .modal-content { border: 0; border-radius: 18px; overflow: hidden; }
        .pl-modal .modal-header { border-bottom: 1px solid #dbe5df; padding: 18px 22px; }
        .pl-modal .modal-title { font-family: 'Fraunces', serif; font-weight: 700; color: #0f3d2e; font-size: 1.2rem; letter-spacing: -0.3px; }
        .pl-modal .modal-body { padding: 20px 22px; }
        .pl-modal .modal-footer { border-top: 1px solid #dbe5df; background: #f4f7f5; padding: 14px 22px; }
        .pl-modal .form-label { font-weight: 600; font-size: 0.9rem; }
        .pl-modal .form-control { font-size: 0.95rem; padding: 10px 13px; font-weight: 500; }
        .pl-modal .btn { border-radius: 999px; padding: 9px 22px; font-weight: 600; }
        .pl-modal .btn-success { background: #1d6b4f; border-color: #1d6b4f; }
        .pl-modal .btn-success:hover { background: #0f3d2e; border-color: #0f3d2e; }
        .ikon-hapus { width: 56px; height: 56px; border-radius: 50%; background: #fbeceb; color: #b3322b; display: grid; place-items: center; font-size: 1.4rem; margin: 0 auto 14px; }
    </style>

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <h2 class="fw-bold pl-judul" style="color: var(--hijau-tua);">Data Pelatih</h2>
        <button class="btn btn-success pl-tambah" data-bs-toggle="modal" data-bs-target="#modalTambahPelatih">
            <i class="fas fa-plus"></i> Tambah Pelatih
        </button>
    </div>

    @if(session('sukses'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('sukses') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- FILTER TOGGLE (KHUSUS HP) -->
    <button class="btn pl-filter-toggle d-md-none w-100" type="button" data-bs-toggle="collapse" data-bs-target="#panelFilterPelatih" aria-expanded="{{ $jumlahFilter ? 'true' : 'false' }}" aria-controls="panelFilterPelatih">
        <i class="fas fa-filter"></i> Filter Data Pelatih
        @if($jumlahFilter)<span class="jml">{{ $jumlahFilter }}</span>@endif
        <i class="fas fa-chevron-down panah"></i>
    </button>

    <!-- FORM FILTER -->
    <div class="collapse d-md-block {{ $jumlahFilter ? 'show' : '' }}" id="panelFilterPelatih">
        <div class="card border-0 shadow-sm mb-4 pl-filter">
            <div class="card-body">
                <form action="/admin/pelatih" method="GET" class="row g-3 align-items-end">
                    <div class="col-12 col-md-5">
                        <label class="form-label" for="f_nama">Cari Nama Pelatih</label>
                        <input type="text" id="f_nama" name="nama" class="form-control" placeholder="Ketik nama pelatih..." value="{{ request('nama') }}">
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label" for="f_alamat">Cari Alamat</label>
                        <input type="text" id="f_alamat" name="alamat" class="form-control" placeholder="Ketik alamat..." value="{{ request('alamat') }}">
                    </div>
                    <div class="col-12 col-md-3">
                        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i> Terapkan</button>
                    </div>
                </form>
                @if($jumlahFilter)
                    <a href="/admin/pelatih" class="pl-reset"><i class="fas fa-rotate-left me-1"></i>Hapus semua filter</a>
                @endif
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm pl-card-tabel">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle pl-tabel mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Pelatih</th>
                        <th>No HP</th>
                        <th>Alamat</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelatih as $index => $p)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="nama">
                            <div class="nama-sel">
                                <span class="pl-avatar">{{ strtoupper(mb_substr($p->nama_pelatih, 0, 1)) }}</span>
                                <span>{{ $p->nama_pelatih }}</span>
                            </div>
                        </td>
                        <td>{{ $p->no_hp }}</td>
                        <td>{{ $p->alamat }}</td>
                        <td class="aksi">
                            <div class="aksi-grup">
                                <button class="btn btn-sm btn-primary btn-ikon" data-bs-toggle="modal" data-bs-target="#modalEditPelatih"
                                    data-id="{{ $p->id }}"
                                    data-nama="{{ $p->nama_pelatih }}"
                                    data-alamat="{{ $p->alamat }}"
                                    data-hp="{{ $p->no_hp }}" aria-label="Edit {{ $p->nama_pelatih }}">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <button class="btn btn-sm btn-danger btn-ikon" data-bs-toggle="modal" data-bs-target="#modalHapusPelatih"
                                    data-id="{{ $p->id }}"
                                    data-nama="{{ $p->nama_pelatih }}" aria-label="Hapus {{ $p->nama_pelatih }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center pl-kosong">
                            {{ $jumlahFilter ? 'Tidak ada data pelatih yang cocok dengan filter.' : 'Belum ada data pelatih.' }}
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL TAMBAH -->
    <div class="modal fade pl-modal" id="modalTambahPelatih" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form action="/admin/pelatih" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Pelatih</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3"><label class="form-label" for="tp_nama">Nama Pelatih</label><input type="text" id="tp_nama" name="nama_pelatih" class="form-control" required></div>
                        <div class="mb-3"><label class="form-label" for="tp_alamat">Alamat</label><textarea id="tp_alamat" name="alamat" class="form-control" rows="2" required></textarea></div>
                        <div class="mb-1"><label class="form-label" for="tp_hp">No HP</label><input type="number" id="tp_hp" name="no_hp" class="form-control" inputmode="numeric" required></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL EDIT -->
    <div class="modal fade pl-modal" id="modalEditPelatih" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form id="formEditPelatih" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Data Pelatih</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3"><label class="form-label" for="edit_nama_pelatih">Nama Pelatih</label><input type="text" name="nama_pelatih" id="edit_nama_pelatih" class="form-control" required></div>
                        <div class="mb-3"><label class="form-label" for="edit_alamat_pelatih">Alamat</label><textarea name="alamat" id="edit_alamat_pelatih" class="form-control" rows="2" required></textarea></div>
                        <div class="mb-1"><label class="form-label" for="edit_hp_pelatih">No HP</label><input type="number" name="no_hp" id="edit_hp_pelatih" class="form-control" inputmode="numeric" required></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL HAPUS -->
    <div class="modal fade pl-modal" id="modalHapusPelatih" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="formHapusPelatih" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body text-center">
                        <div class="ikon-hapus"><i class="fas fa-trash-can"></i></div>
                        <p class="mb-0">Apakah Anda yakin ingin menghapus data <strong id="hapus_nama_pelatih"></strong>?</p>
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
        function setupModal(modalId, callback) {
            var modal = document.getElementById(modalId);
            if (modal) {
                modal.addEventListener('show.bs.modal', function (event) {
                    if (event.relatedTarget) callback(event.relatedTarget);
                });
            }
        }

        setupModal('modalEditPelatih', function(button) {
            var id = button.getAttribute('data-id');
            document.getElementById('formEditPelatih').action = '/admin/pelatih/' + id;
            document.getElementById('edit_nama_pelatih').value = button.getAttribute('data-nama');
            document.getElementById('edit_alamat_pelatih').value = button.getAttribute('data-alamat');
            document.getElementById('edit_hp_pelatih').value = button.getAttribute('data-hp');
        });

        setupModal('modalHapusPelatih', function(button) {
            var id = button.getAttribute('data-id');
            var nama = button.getAttribute('data-nama');
            document.getElementById('formHapusPelatih').action = '/admin/pelatih/' + id;
            document.getElementById('hapus_nama_pelatih').textContent = nama;
        });
    });
</script>
@endpush