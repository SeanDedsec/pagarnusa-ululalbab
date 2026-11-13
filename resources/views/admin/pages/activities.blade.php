@extends('admin.layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold" style="color: var(--hijau-tua);">Kelola Kegiatan</h2>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambahKegiatan">
            <i class="fas fa-plus"></i> Tambah Kegiatan
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
                        <th>Tanggal</th>
                        <th>Judul Kegiatan</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kegiatan as $k)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($k->tanggal)->format('d M Y') }}</td>
                        <td class="fw-bold">{{ $k->judul }}</td>
                        <td>{{ $k->lokasi }}</td>
                        <td>
                            @if($k->status_publikasi == 'publikasi')
                                <span class="badge bg-success">Publikasi</span>
                            @else
                                <span class="badge bg-secondary">Draf</span>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalEditKegiatan"
                                data-id="{{ $k->id }}" 
                                data-judul="{{ $k->judul }}" 
                                data-deskripsi="{{ $k->deskripsi }}" 
                                data-tanggal="{{ $k->tanggal }}" 
                                data-lokasi="{{ $k->lokasi }}"
                                data-status="{{ $k->status_publikasi }}">
                                <i class="fas fa-edit"></i>
                            </button>

                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapusKegiatan"
                                data-id="{{ $k->id }}" 
                                data-judul="{{ $k->judul }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada data kegiatan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modalTambahKegiatan" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/admin/kegiatan" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Kegiatan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-2"><label>Judul Kegiatan</label><input type="text" name="judul" class="form-control" required></div>
                        <div class="mb-2"><label>Tanggal</label><input type="date" name="tanggal" class="form-control" required></div>
                        <div class="mb-2"><label>Lokasi</label><input type="text" name="lokasi" class="form-control" required></div>
                        <div class="mb-2"><label>Deskripsi</label><textarea name="deskripsi" class="form-control" rows="3" required></textarea></div>
                        <div class="mb-2">
                            <label>Status</label>
                            <select name="status_publikasi" class="form-select" required>
                                <option value="draf">Simpan sebagai Draf</option>
                                <option value="publikasi">Publikasikan ke Web</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditKegiatan" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formEditKegiatan" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Kegiatan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-2"><label>Judul Kegiatan</label><input type="text" name="judul" id="edit_judul_kegiatan" class="form-control" required></div>
                        <div class="mb-2"><label>Tanggal</label><input type="date" name="tanggal" id="edit_tanggal_kegiatan" class="form-control" required></div>
                        <div class="mb-2"><label>Lokasi</label><input type="text" name="lokasi" id="edit_lokasi_kegiatan" class="form-control" required></div>
                        <div class="mb-2"><label>Deskripsi</label><textarea name="deskripsi" id="edit_deskripsi_kegiatan" class="form-control" rows="3" required></textarea></div>
                        <div class="mb-2">
                            <label>Status</label>
                            <select name="status_publikasi" id="edit_status_kegiatan" class="form-select" required>
                                <option value="draf">Simpan sebagai Draf</option>
                                <option value="publikasi">Publikasikan ke Web</option>
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

    <div class="modal fade" id="modalHapusKegiatan" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formHapusKegiatan" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus kegiatan <strong id="hapus_judul_kegiatan"></strong>?</p>
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

        setupModal('modalEditKegiatan', function(button) {
            var id = button.getAttribute('data-id');
            document.getElementById('formEditKegiatan').action = '/admin/kegiatan/' + id;
            document.getElementById('edit_judul_kegiatan').value = button.getAttribute('data-judul');
            document.getElementById('edit_deskripsi_kegiatan').value = button.getAttribute('data-deskripsi');
            document.getElementById('edit_tanggal_kegiatan').value = button.getAttribute('data-tanggal');
            document.getElementById('edit_lokasi_kegiatan').value = button.getAttribute('data-lokasi');
            document.getElementById('edit_status_kegiatan').value = button.getAttribute('data-status');
        });

        setupModal('modalHapusKegiatan', function(button) {
            var id = button.getAttribute('data-id');
            var judul = button.getAttribute('data-judul');
            document.getElementById('formHapusKegiatan').action = '/admin/kegiatan/' + id;
            document.getElementById('hapus_judul_kegiatan').textContent = judul;
        });
    });
</script>
@endpush