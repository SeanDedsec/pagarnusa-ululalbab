@extends('admin.layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold" style="color: var(--hijau-tua);">Data Pelatih</h2>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambahPelatih">
            <i class="fas fa-plus"></i> Tambah Pelatih
        </button>
    </div>

    @if(session('sukses'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('sukses') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
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
                        <td>{{ $index + 1 }}</td>
                        <td class="fw-bold">{{ $p->nama_pelatih }}</td>
                        <td>{{ $p->no_hp }}</td>
                        <td>{{ $p->alamat }}</td>
                        <td>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalEditPelatih"
                                data-id="{{ $p->id }}" 
                                data-nama="{{ $p->nama_pelatih }}" 
                                data-alamat="{{ $p->alamat }}" 
                                data-hp="{{ $p->no_hp }}">
                                <i class="fas fa-edit"></i>
                            </button>

                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapusPelatih"
                                data-id="{{ $p->id }}" 
                                data-nama="{{ $p->nama_pelatih }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada data pelatih.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL TAMBAH -->
    <div class="modal fade" id="modalTambahPelatih" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/admin/pelatih" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Pelatih</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-2"><label>Nama Pelatih</label><input type="text" name="nama_pelatih" class="form-control" required></div>
                        <div class="mb-2"><label>Alamat</label><textarea name="alamat" class="form-control" required></textarea></div>
                        <div class="mb-2"><label>No HP</label><input type="number" name="no_hp" class="form-control" required></div>
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
    <div class="modal fade" id="modalEditPelatih" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formEditPelatih" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Data Pelatih</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-2"><label>Nama Pelatih</label><input type="text" name="nama_pelatih" id="edit_nama_pelatih" class="form-control" required></div>
                        <div class="mb-2"><label>Alamat</label><textarea name="alamat" id="edit_alamat_pelatih" class="form-control" required></textarea></div>
                        <div class="mb-2"><label>No HP</label><input type="number" name="no_hp" id="edit_hp_pelatih" class="form-control" required></div>
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
    <div class="modal fade" id="modalHapusPelatih" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formHapusPelatih" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus data <strong id="hapus_nama_pelatih"></strong>?</p>
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