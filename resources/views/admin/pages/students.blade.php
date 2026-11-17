@extends('admin.layouts.app')

@section('content')
    <style>
        /* ---------- Data Siswa ---------- */
        .sw-judul { font-size: clamp(1.4rem, 4vw, 1.8rem); margin: 0; }
        .sw-aksi .btn { padding: 10px 18px; }
        .sw-aksi .btn-success { background: #1d6b4f; border-color: #1d6b4f; }
        .sw-aksi .btn-success:hover { background: #0f3d2e; border-color: #0f3d2e; }
        @media (max-width: 575.98px) {
            .sw-aksi { width: 100%; display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
            .sw-aksi .btn { margin: 0 !important; width: 100%; }
        }

        /* Filter */
        .sw-filter { background: #fff; border: 1px solid #dbe5df !important; border-radius: 14px; }
        .sw-filter .form-label { font-size: .85rem; margin-bottom: 5px; }
        .sw-filter .form-control, .sw-filter .form-select { font-size: 1rem; padding: 11px 13px; }
        .sw-filter .btn-primary { padding: 11px; }
        .sw-reset { display: inline-block; margin-top: 8px; font-size: .88rem; font-weight: 600; color: #5d6b64; text-decoration: none; }
        .sw-reset:hover { color: #b3322b; }

        /* Tabel */
        .sw-tabel .nama-sel { display: flex; align-items: center; gap: 12px; font-weight: 600; color: #0f3d2e; }
        .sw-avatar { width: 36px; height: 36px; border-radius: 50%; background: #e8f1ec; color: #1d6b4f; display: grid; place-items: center; font-weight: 700; font-size: .9rem; flex-shrink: 0; }
        .sw-tabel .badge { padding: .45em .8em; border-radius: 999px; }
        .sw-tabel .badge.bg-success { background: #e8f1ec !important; color: #0f3d2e; }
        .sw-tabel .badge.bg-warning { background: #fff4d1 !important; color: #6b5200 !important; }
        .sw-tabel .badge.bg-danger { background: #fbeceb !important; color: #8f2620; }
        .sw-tabel .aksi-grup { display: flex; gap: 6px; flex-wrap: wrap; }
        .sw-tabel .aksi-grup .btn { border-radius: 10px; }
        .sw-tabel .btn-ikon { width: 38px; height: 38px; padding: 0; display: inline-grid; place-items: center; }
        .sw-tabel .btn-warning { background: #c9a227; border-color: #c9a227; }
        .sw-tabel .btn-warning:hover { background: #a8861a; border-color: #a8861a; color: #fff !important; }
        .sw-kosong { padding: 36px 12px !important; color: #5d6b64; }

        /* Tabel jadi kartu di HP */
        @media (max-width: 767.98px) {
            .sw-tabel thead { display: none; }
            .sw-tabel, .sw-tabel tbody, .sw-tabel tr, .sw-tabel td { display: block; width: 100%; }
            .sw-tabel tbody tr { border: 1px solid #dbe5df; border-radius: 12px; margin-bottom: 12px; padding: 6px 14px 12px; background: #fff; }
            .sw-tabel td { display: flex; justify-content: space-between; align-items: center; gap: 16px; padding: 9px 0 !important; border: 0; border-bottom: 1px dashed #e3ebe6; text-align: right; }
            .sw-tabel td::before { content: attr(data-label); font-size: .8rem; font-weight: 600; color: #5d6b64; text-align: left; flex-shrink: 0; }
            .sw-tabel td.no { display: none; }
            .sw-tabel td.nama { font-size: 1.02rem; padding-top: 12px !important; }
            .sw-tabel td.nama::before { content: none; }
            .sw-tabel td.nama .nama-sel { width: 100%; text-align: left; }
            .sw-tabel td.aksi { border-bottom: 0; padding: 12px 0 0 !important; display: block; }
            .sw-tabel td.aksi::before { content: none; }
            .sw-tabel td.aksi .aksi-grup { flex-wrap: nowrap; }
            .sw-tabel td.aksi .btn-absen { flex: 1; height: 42px; }
            .sw-tabel .btn-ikon { width: 42px; height: 42px; }
            .sw-tabel td.sw-kosong { display: block; text-align: center; }
            .sw-tabel td.sw-kosong::before { content: none; }
            .sw-card-tabel { background: transparent !important; border: 0 !important; }
            .sw-card-tabel .card-body { padding: 0; }
        }

        /* Modal */
        .sw-modal .modal-content { border: 0; border-radius: 18px; overflow: hidden; }
        .sw-modal .modal-header { border-bottom: 1px solid #dbe5df; padding: 18px 22px; }
        .sw-modal .modal-title { font-family: 'Fraunces', serif; font-weight: 700; color: #0f3d2e; font-size: 1.2rem; }
        .sw-modal .modal-header.bg-warning { background: #fff4d1 !important; border-bottom-color: #ecd98c; }
        .sw-modal .modal-header.bg-warning .modal-title { color: #4d3b00 !important; }
        .sw-modal .modal-body { padding: 20px 22px; }
        .sw-modal .modal-footer { border-top: 1px solid #dbe5df; background: #f4f7f5; padding: 14px 22px; }
        .sw-modal .form-control, .sw-modal .form-select { font-size: 1rem; padding: 11px 13px; }
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

    <!-- FORM FILTER (BARU) -->
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
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i> Filter Data</button>
                </div>
            </form>
            @if(request()->hasAny(['nama', 'status']))
                <a href="/admin/siswa" class="sw-reset"><i class="fas fa-rotate-left me-1"></i>Hapus semua filter</a>
            @endif
        </div>
    </div>

    <div class="card border-0 shadow-sm sw-card-tabel">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle sw-tabel mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>No HP</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswa as $index => $s)
                    <tr>
                        <td class="no" data-label="No">{{ $index + 1 }}</td>
                        <td class="nama" data-label="Nama Siswa">
                            <div class="nama-sel">
                                <span class="sw-avatar">{{ strtoupper(mb_substr($s->nama_siswa, 0, 1)) }}</span>
                                <span>{{ $s->nama_siswa }}</span>
                            </div>
                        </td>
                        <td data-label="No HP">{{ $s->no_hp }}</td>
                        <td data-label="Status">
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
                                    <i class="fas fa-clipboard-check"></i> Absen/Kas
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