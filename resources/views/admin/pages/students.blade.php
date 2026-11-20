@extends('admin.layouts.app')

@section('content')
    @php
        // Hitung filter yang terisi
        $jumlahFilter = collect(['nama', 'status'])->filter(fn($f) => request()->filled($f))->count();
    @endphp

    <style>
        /* ---------- Optimasi Ketajaman Teks ---------- */
        .sw-judul, .sw-tabel, .sw-modal, .sw-filter {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
        }

        /* ---------- Data Siswa ---------- */
        .sw-judul { font-size: clamp(1.3rem, 4vw, 1.8rem); margin: 0; letter-spacing: -0.5px; }
        .sw-aksi .btn { padding: 10px 18px; font-weight: 600; }
        .sw-aksi .btn-success { background: #1d6b4f; border-color: #1d6b4f; }
        .sw-aksi .btn-success:hover { background: #0f3d2e; border-color: #0f3d2e; }
        
        @media (max-width: 575.98px) {
            .sw-aksi { width: 100%; display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
            .sw-aksi .btn { margin: 0 !important; width: 100%; font-size: 0.9rem; }
        }

        /* Filter */
        .sw-filter-toggle {
            display: flex; align-items: center; gap: 10px; justify-content: center;
            background: #fff; border: 1.5px solid #dbe5df; color: #0f3d2e; font-weight: 600;
            border-radius: 12px; padding: 12px; margin-bottom: 10px;
        }
        .sw-filter-toggle:hover { background: #e8f1ec; color: #0f3d2e; }
        .sw-filter-toggle .jml { background: #1d6b4f; color: #fff; border-radius: 999px; font-size: .75rem; padding: 2px 9px; font-weight: 700; }
        .sw-filter-toggle .panah { transition: transform .2s; margin-left: auto; }
        .sw-filter-toggle[aria-expanded="true"] .panah { transform: rotate(180deg); }

        .sw-filter { background: #fff; border: 1px solid #dbe5df !important; border-radius: 14px; }
        .sw-filter .form-label { font-size: .85rem; font-weight: 600; margin-bottom: 5px; }
        .sw-filter .form-control, .sw-filter .form-select { font-size: 0.95rem; padding: 11px 13px; font-weight: 500; }
        .sw-filter .btn-primary { padding: 11px; font-weight: 600; }
        .sw-reset { display: inline-block; margin-top: 8px; font-size: .88rem; font-weight: 600; color: #5d6b64; text-decoration: none; }
        .sw-reset:hover { color: #b3322b; }

        /* Tabel Utama */
        .sw-tabel .nama-sel { display: flex; align-items: center; gap: 10px; font-weight: 600; color: #0f3d2e; }
        .sw-avatar { width: 34px; height: 34px; border-radius: 50%; background: #e8f1ec; color: #1d6b4f; display: grid; place-items: center; font-weight: 700; font-size: .85rem; flex-shrink: 0; }
        
        .sw-tabel th { font-weight: 700; color: #16241d; font-size: 0.85rem; letter-spacing: 0.3px; }
        .sw-tabel td { font-weight: 500; color: #333; font-size: 0.9rem; }
        
        .sw-tabel .badge { padding: .45em .8em; border-radius: 999px; font-weight: 600; }
        .sw-tabel .badge.bg-success { background: #e8f1ec !important; color: #0f3d2e; }
        .sw-tabel .badge.bg-warning { background: #fff4d1 !important; color: #6b5200 !important; }
        .sw-tabel .badge.bg-danger { background: #fbeceb !important; color: #8f2620; }
        
        /* Tombol Aksi */
        .sw-tabel .aksi-grup { 
            display: flex; 
            flex-direction: row; /* Memastikan horizontal */
            flex-wrap: nowrap; /* Mencegah turun ke bawah */
            gap: 6px; 
            align-items: center;
        }
        .sw-tabel .aksi-grup .btn { border-radius: 8px; flex-shrink: 0; }
        .sw-tabel .btn-ikon { width: 36px; height: 36px; padding: 0; display: inline-grid; place-items: center; }
        .sw-tabel .btn-absen { height: 36px; padding: 0 10px; font-size: 0.8rem; display: flex; align-items: center; gap: 5px; }
        
        .sw-tabel .btn-warning { background: #c9a227; border-color: #c9a227; }
        .sw-tabel .btn-warning:hover { background: #a8861a; border-color: #a8861a; color: #fff !important; }
        .sw-kosong { padding: 36px 12px !important; color: #5d6b64; font-weight: 500; }

        /* ---------- Tampilan Tabel di HP (Mobile) ---------- */
        @media (max-width: 767.98px) {
            .sw-card-tabel .card-body { padding: 10px; }
            .sw-tabel { min-width: 750px; /* Lebar minimum agar proporsional */ }
            
            .sw-tabel th, .sw-tabel td {
                font-size: 0.8rem; 
                padding: 8px 6px !important;
                white-space: nowrap;
            }
            
            .sw-tabel .sw-avatar { width: 28px; height: 28px; font-size: 0.75rem; margin-right: 2px; }
            
            /* Ukuran tombol aksi di HP agar pas horizontal */
            .sw-tabel .btn-ikon { width: 32px; height: 32px; font-size: 0.75rem; }
            .sw-tabel .btn-absen { height: 32px; padding: 0 8px; font-size: 0.7rem; }
            .sw-tabel .aksi-grup { gap: 4px; }
        }

        /* Modal */
        .sw-modal .modal-content { border: 0; border-radius: 18px; overflow: hidden; }
        .sw-modal .modal-header { border-bottom: 1px solid #dbe5df; padding: 18px 22px; }
        .sw-modal .modal-title { font-family: 'Fraunces', serif; font-weight: 700; color: #0f3d2e; font-size: 1.2rem; letter-spacing: -0.3px; }
        .sw-modal .modal-header.bg-warning { background: #fff4d1 !important; border-bottom-color: #ecd98c; }
        .sw-modal .modal-header.bg-warning .modal-title { color: #4d3b00 !important; }
        .sw-modal .modal-body { padding: 20px 22px; }
        .sw-modal .modal-footer { border-top: 1px solid #dbe5df; background: #f4f7f5; padding: 14px 22px; }
        .sw-modal .form-label { font-weight: 600; font-size: 0.9rem; }
        .sw-modal .form-control, .sw-modal .form-select { font-size: 0.95rem; padding: 10px 13px; font-weight: 500; }
        .sw-modal .btn { border-radius: 999px; padding: 9px 22px; font-weight: 600; }
        .sw-modal .btn-success { background: #1d6b4f; border-color: #1d6b4f; }
        .sw-modal .btn-success:hover { background: #0f3d2e; border-color: #0f3d2e; }
        .sw-modal .btn-warning { background: #c9a227; border-color: #c9a227; }
        .sw-modal .btn-warning:hover { background: #a8861a; border-color: #a8861a; color: #fff !important; }
        .ikon-hapus { width: 56px; height: 56px; border-radius: 50%; background: #fbeceb; color: #b3322b; display: grid; place-items: center; font-size: 1.4rem; margin: 0 auto 14px; }
    </style>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <strong>Gagal menyimpan!</strong> {{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <h2 class="fw-bold sw-judul" style="color: var(--hijau-tua);">Data Siswa</h2>
        <div class="sw-aksi">
            <a href="/admin/siswa/cetak-pdf" class="btn btn-danger me-2">
                <i class="fas fa-file-pdf"></i> Cetak PDF
            </a>

            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="fas fa-plus"></i> Tambah Siswa
            </button>
        </div>
    </div>

    @if(session('sukses'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('sukses') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- FILTER TOGGLE (KHUSUS HP) -->
    <button class="btn sw-filter-toggle d-md-none w-100" type="button" data-bs-toggle="collapse" data-bs-target="#panelFilterSiswa" aria-expanded="{{ $jumlahFilter ? 'true' : 'false' }}" aria-controls="panelFilterSiswa">
        <i class="fas fa-filter"></i> Filter Data Siswa
        @if($jumlahFilter)<span class="jml">{{ $jumlahFilter }}</span>@endif
        <i class="fas fa-chevron-down panah"></i>
    </button>

    <!-- FORM FILTER -->
    <div class="collapse d-md-block {{ $jumlahFilter ? 'show' : '' }}" id="panelFilterSiswa">
        <div class="card border-0 shadow-sm mb-4 sw-filter">
            <div class="card-body">
                <form action="/admin/siswa" method="GET" class="row g-3 align-items-end">
                    <div class="col-12 col-md-5">
                        <label class="form-label" for="f_nama">Cari Nama Siswa</label>
                        <input type="text" id="f_nama" name="nama" class="form-control" placeholder="Ketik nama siswa..." value="{{ request('nama') }}">
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label" for="f_status">Status</label>
                        <select id="f_status" name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-3">
                        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i> Terapkan</button>
                    </div>
                </form>
                @if($jumlahFilter)
                    <a href="/admin/siswa" class="sw-reset"><i class="fas fa-rotate-left me-1"></i>Hapus semua filter</a>
                @endif
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm sw-card-tabel">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle sw-tabel mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Siswa</th>
                        <th>No HP</th>
                        <th>Status</th>
                        <th width="20%">Aksi</th> <!-- Lebar Aksi ditambah agar muat 3 tombol -->
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswa as $index => $s)
                    <tr>
                        <td class="no">{{ $index + 1 }}</td>
                        <td class="nama">
                            <div class="nama-sel">
                                <span class="sw-avatar">{{ strtoupper(mb_substr($s->nama_siswa, 0, 1)) }}</span>
                                <span>{{ $s->nama_siswa }}</span>
                            </div>
                        </td>
                        <td>{{ $s->no_hp }}</td>
                        <td>
                            @if($s->status == 'aktif')
                                <span class="badge bg-success">Aktif</span>
                            @elseif($s->status == 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @else
                                <span class="badge bg-danger">Nonaktif</span>
                            @endif
                        </td>
                        <td class="aksi">
                            <div class="aksi-grup">
                                <button class="btn btn-sm btn-primary btn-ikon" data-bs-toggle="modal" data-bs-target="#modalEdit"
                                    data-id="{{ $s->id }}"
                                    data-nama="{{ $s->nama_siswa }}"
                                    data-alamat="{{ $s->alamat }}"
                                    data-hp="{{ $s->no_hp }}"
                                    data-tgl="{{ $s->tanggal_lahir }}"
                                    data-status="{{ $s->status }}" aria-label="Edit {{ $s->nama_siswa }}">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <button class="btn btn-sm btn-warning text-dark fw-bold btn-absen" data-bs-toggle="modal" data-bs-target="#modalAbsensi"
                                    data-id="{{ $s->id }}"
                                    data-nama="{{ $s->nama_siswa }}">
                                    <i class="fas fa-clipboard-check"></i> Absen
                                </button>

                                <button class="btn btn-sm btn-danger btn-ikon" data-bs-toggle="modal" data-bs-target="#modalHapus"
                                    data-id="{{ $s->id }}"
                                    data-nama="{{ $s->nama_siswa }}" aria-label="Hapus {{ $s->nama_siswa }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center sw-kosong">Tidak ada data siswa yang cocok dengan filter.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL TAMBAH -->
    <div class="modal fade sw-modal" id="modalTambah" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form action="/admin/siswa" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Siswa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3"><label class="form-label" for="t_nama">Nama Siswa</label><input type="text" id="t_nama" name="nama_siswa" class="form-control" required></div>
                        <div class="mb-3"><label class="form-label" for="t_alamat">Alamat</label><textarea id="t_alamat" name="alamat" class="form-control" rows="2" required></textarea></div>
                        <div class="mb-3"><label class="form-label" for="t_hp">No HP</label><input type="number" id="t_hp" name="no_hp" class="form-control" inputmode="numeric" required></div>
                        <div class="mb-1"><label class="form-label" for="t_tgl">Tanggal Lahir</label><input type="date" id="t_tgl" name="tanggal_lahir" class="form-control" required></div>
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
    <div class="modal fade sw-modal" id="modalEdit" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form id="formEdit" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Data Siswa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3"><label class="form-label" for="edit_nama">Nama Siswa</label><input type="text" name="nama_siswa" id="edit_nama" class="form-control" required></div>
                        <div class="mb-3"><label class="form-label" for="edit_alamat">Alamat</label><textarea name="alamat" id="edit_alamat" class="form-control" rows="2" required></textarea></div>
                        <div class="mb-3"><label class="form-label" for="edit_hp">No HP</label><input type="number" name="no_hp" id="edit_hp" class="form-control" inputmode="numeric" required></div>
                        <div class="mb-3"><label class="form-label" for="edit_tgl">Tanggal Lahir</label><input type="date" name="tanggal_lahir" id="edit_tgl" class="form-control" required></div>
                        <div class="mb-1">
                            <label class="form-label" for="edit_status">Status</label>
                            <select name="status" id="edit_status" class="form-control" required>
                                <option value="pending">Pending</option>
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
                        </div>
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
    <div class="modal fade sw-modal" id="modalHapus" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="formHapus" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body text-center">
                        <div class="ikon-hapus"><i class="fas fa-trash-can"></i></div>
                        <p class="mb-0">Apakah Anda yakin ingin menghapus data <strong id="hapus_nama"></strong>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL ABSENSI -->
    <div class="modal fade sw-modal" id="modalAbsensi" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form action="/admin/absensi" method="POST">
                    @csrf
                    <input type="hidden" name="siswa_id" id="absen_siswa_id">

                    <div class="modal-header bg-warning">
                        <h5 class="modal-title text-dark fw-bold">Absensi & Kas: <span id="absen_nama_siswa"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="a_jadwal">Pilih Jadwal Latihan</label>
                            <select name="jadwal_id" id="a_jadwal" class="form-select" required>
                                <option value="1">Minggu Sore (15:00 - 17:00)</option>
                                <option value="2">Kamis Sore (15:00 - 17:00)</option>
                                <option value="3">Senin Malam (19:00 - 21:00)</option>
                                <option value="4">Kamis Malam (19:00 - 21:00)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="a_tanggal">Tanggal Latihan</label>
                            <input type="date" name="tanggal" id="a_tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="a_status">Status Kehadiran</label>
                            <select name="status_kehadiran" id="a_status" class="form-select" required>
                                <option value="hadir">Hadir</option>
                                <option value="izin">Izin</option>
                                <option value="sakit">Sakit</option>
                            </select>
                        </div>
                        <div class="mb-1">
                            <label class="form-label fw-bold" for="a_kas">Nominal Kas (Rp)</label>
                            <input type="number" name="nominal_kas" id="a_kas" class="form-control" inputmode="numeric" value="5000" required>
                            <small class="text-muted">Ubah menjadi 0 jika siswa tidak membayar kas.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning fw-bold text-dark">Simpan Absensi & Kas</button>
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
                    var button = event.relatedTarget;
                    if (button) {
                        callback(button);
                    }
                });
            }
        }

        setupModal('modalEdit', function(button) {
            var id = button.getAttribute('data-id');
            document.getElementById('formEdit').action = '/admin/siswa/' + id;
            document.getElementById('edit_nama').value = button.getAttribute('data-nama');
            document.getElementById('edit_alamat').value = button.getAttribute('data-alamat');
            document.getElementById('edit_hp').value = button.getAttribute('data-hp');
            document.getElementById('edit_tgl').value = button.getAttribute('data-tgl');
            document.getElementById('edit_status').value = button.getAttribute('data-status');
        });

        setupModal('modalHapus', function(button) {
            var id = button.getAttribute('data-id');
            var nama = button.getAttribute('data-nama');
            document.getElementById('formHapus').action = '/admin/siswa/' + id;
            document.getElementById('hapus_nama').textContent = nama;
        });

        setupModal('modalAbsensi', function(button) {
            var id = button.getAttribute('data-id');
            var nama = button.getAttribute('data-nama');
            var inputId = document.getElementById('absen_siswa_id');
            var textNama = document.getElementById('absen_nama_siswa');
            
            if (inputId) {
                inputId.value = id;
            }
            if (textNama) {
                textNama.textContent = nama;
            }
        });
    });
</script>
@endpush