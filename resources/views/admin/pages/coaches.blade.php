@extends('admin.layouts.app')

@section('content')
    <style>
        /* ---------- Data Pelatih ---------- */
        .pl-judul { font-size: clamp(1.4rem, 4vw, 1.8rem); margin: 0; }
        .pl-tambah { background: #1d6b4f; border-color: #1d6b4f; padding: 10px 18px; }
        .pl-tambah:hover { background: #0f3d2e; border-color: #0f3d2e; }
        @media (max-width: 575.98px) {
            .pl-tambah { width: 100%; }
        }

        /* Tabel */
        .pl-tabel .nama-sel { display: flex; align-items: center; gap: 12px; font-weight: 700; color: #0f3d2e; }
        .pl-avatar { width: 36px; height: 36px; border-radius: 50%; background: #1d6b4f; color: #fff; display: grid; place-items: center; font-weight: 700; font-size: .9rem; flex-shrink: 0; }
        .pl-tabel .aksi-grup { display: flex; gap: 6px; }
        .pl-tabel .btn-ikon { width: 38px; height: 38px; padding: 0; display: inline-grid; place-items: center; border-radius: 10px; }
        .pl-kosong { padding: 36px 12px !important; color: #5d6b64; }

        /* Tabel jadi kartu di HP */
        @media (max-width: 767.98px) {
            .pl-tabel thead { display: none; }
            .pl-tabel, .pl-tabel tbody, .pl-tabel tr, .pl-tabel td { display: block; width: 100%; }
            .pl-tabel tbody tr { border: 1px solid #dbe5df; border-radius: 12px; margin-bottom: 12px; padding: 6px 14px 12px; background: #fff; }
            .pl-tabel td { display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; padding: 9px 0 !important; border: 0; border-bottom: 1px dashed #e3ebe6; text-align: right; }
            .pl-tabel td::before { content: attr(data-label); font-size: .8rem; font-weight: 600; color: #5d6b64; text-align: left; flex-shrink: 0; }
            .pl-tabel td.no { display: none; }
            .pl-tabel td.nama { padding-top: 12px !important; font-size: 1.02rem; }
            .pl-tabel td.nama::before { content: none; }
            .pl-tabel td.nama .nama-sel { width: 100%; text-align: left; }
            .pl-tabel td.aksi { border-bottom: 0; padding: 12px 0 0 !important; display: block; }
            .pl-tabel td.aksi::before { content: none; }
            .pl-tabel td.aksi .aksi-grup { gap: 10px; }
            .pl-tabel td.aksi .btn-ikon { flex: 1; width: auto; height: 42px; }
            .pl-tabel td.pl-kosong { display: block; text-align: center; }
            .pl-tabel td.pl-kosong::before { content: none; }
            .pl-card-tabel { background: transparent !important; border: 0 !important; }
            .pl-card-tabel .card-body { padding: 0; }
        }

        /* Modal */
        .pl-modal .modal-content { border: 0; border-radius: 18px; overflow: hidden; }
        .pl-modal .modal-header { border-bottom: 1px solid #dbe5df; padding: 18px 22px; }
        .pl-modal .modal-title { font-family: 'Fraunces', serif; font-weight: 700; color: #0f3d2e; font-size: 1.2rem; }
        .pl-modal .modal-body { padding: 20px 22px; }
        .pl-modal .modal-footer { border-top: 1px solid #dbe5df; background: #f4f7f5; padding: 14px 22px; }
        .pl-modal .form-control { font-size: 1rem; padding: 11px 13px; }
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

    <div class="card border-0 shadow-sm pl-card-tabel">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle pl-tabel mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Pelatih</th>
                        <th>No HP</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelatih as $index => $p)
                    <tr>
                        <td class="no" data-label="No">{{ $index + 1 }}</td>
                        <td class="fw-bold nama" data-label="Nama Pelatih">
                            <div class="nama-sel">
                                <span class="pl-avatar">{{ strtoupper(mb_substr($p->nama_pelatih, 0, 1)) }}</span>
                                <span>{{ $p->nama_pelatih }}</span>
                            </div>
                        </td>
                        <td data-label="No HP">{{ $p->no_hp }}</td>
                        <td data-label="Alamat">{{ $p->alamat }}</td>
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
                        <td colspan="5" class="text-center pl-kosong">Belum ada data pelatih.</td>
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