@extends('admin.layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold" style="color: var(--hijau-tua);">Kelola Galeri</h2>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambahGaleri">
            <i class="fas fa-upload"></i> Upload Foto
        </button>
    </div>

    @if(session('sukses'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('sukses') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        @forelse($galeri as $g)
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm h-100">

                <img src="{{ asset('storage/' . $g->file_foto) }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="{{ $g->judul }}">
                <div class="card-body">
                    <h6 class="fw-bold">{{ $g->judul }}</h6>
                    <small class="text-muted">{{ \Carbon\Carbon::parse($g->tanggal)->format('d M Y') }}</small><br>
                    
                    <!-- Tampilkan nama kegiatan jika ada -->
                    @if($g->kegiatan)
                        <small class="text-primary"><i class="fas fa-link"></i> {{ $g->kegiatan->judul }}</small><br>
                    @endif

                    <span class="badge {{ $g->status_publikasi == 'publikasi' ? 'bg-success' : 'bg-secondary' }} mt-2">
                        {{ ucfirst($g->status_publikasi) }}
                    </span>
                </div>
                <div class="card-footer bg-white border-0 d-flex justify-content-end gap-2">
                    <!-- PERBAIKAN 1: Posisi data-kegiatan dan penutup tag > -->
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalEditGaleri"
                        data-id="{{ $g->id }}" 
                        data-judul="{{ $g->judul }}" 
                        data-deskripsi="{{ $g->deskripsi }}" 
                        data-tanggal="{{ $g->tanggal }}"
                        data-status="{{ $g->status_publikasi }}"
                        data-kegiatan="{{ $g->kegiatan_id }}">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapusGaleri"
                        data-id="{{ $g->id }}" 
                        data-judul="{{ $g->judul }}">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <h5 class="text-muted">Belum ada foto galeri.</h5>
        </div>
        @endforelse
    </div>

    <!-- MODAL TAMBAH -->
    <div class="modal fade" id="modalTambahGaleri" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/admin/galeri" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Upload Foto Galeri</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-2"><label>Judul Foto</label><input type="text" name="judul" class="form-control" required></div>
                        <div class="mb-2">
                            <label>Kaitkan dengan Kegiatan (Opsional)</label>

                            <select name="kegiatan_id" class="form-select">
                                <option value="">-- Foto Umum --</option>
                                @foreach($kegiatan as $k)
                                    <option value="{{ $k->id }}">{{ $k->judul }} ({{ $k->tanggal }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-2"><label>Tanggal</label><input type="date" name="tanggal" class="form-control" required></div>
                        <div class="mb-2"><label>Deskripsi (Opsional)</label><textarea name="deskripsi" class="form-control" rows="2"></textarea></div>
                        <div class="mb-2"><label>Pilih File Foto (JPG/PNG, Maks 2MB)</label><input type="file" name="file_foto" class="form-control" accept="image/*" required></div>
                        <div class="mb-2">
                            <label>Status</label>
                            <select name="status_publikasi" class="form-select" required>
                                <option value="draf">Draf</option>
                                <option value="publikasi">Publikasi</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL EDIT -->
    <div class="modal fade" id="modalEditGaleri" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formEditGaleri" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Foto Galeri</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-2"><label>Judul Foto</label><input type="text" name="judul" id="edit_judul_galeri" class="form-control" required></div>
                        <div class="mb-2">
                            <label>Kaitkan dengan Kegiatan (Opsional)</label>

                            <select name="kegiatan_id" id="edit_kegiatan_id" class="form-select">
                                <option value="">-- Foto Umum --</option>
                                @foreach($kegiatan as $k)
                                    <option value="{{ $k->id }}">{{ $k->judul }} ({{ $k->tanggal }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-2"><label>Tanggal</label><input type="date" name="tanggal" id="edit_tanggal_galeri" class="form-control" required></div>
                        <div class="mb-2"><label>Deskripsi</label><textarea name="deskripsi" id="edit_deskripsi_galeri" class="form-control" rows="2"></textarea></div>
                        <div class="mb-2">
                            <label>Ganti Foto (Biarkan kosong jika tidak diganti)</label>
                            <input type="file" name="file_foto" class="form-control" accept="image/*">
                        </div>
                        <div class="mb-2">
                            <label>Status</label>
                            <select name="status_publikasi" id="edit_status_galeri" class="form-select" required>
                                <option value="draf">Draf</option>
                                <option value="publikasi">Publikasi</option>
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
    <div class="modal fade" id="modalHapusGaleri" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formHapusGaleri" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus foto <strong id="hapus_judul_galeri"></strong>?</p>
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

        setupModal('modalEditGaleri', function(button) {
            var id = button.getAttribute('data-id');
            document.getElementById('formEditGaleri').action = '/admin/galeri/' + id;
            document.getElementById('edit_judul_galeri').value = button.getAttribute('data-judul');
            document.getElementById('edit_deskripsi_galeri').value = button.getAttribute('data-deskripsi');
            document.getElementById('edit_tanggal_galeri').value = button.getAttribute('data-tanggal');
            document.getElementById('edit_status_galeri').value = button.getAttribute('data-status');
            
            // Ini akan berjalan dengan lancar sekarang
            document.getElementById('edit_kegiatan_id').value = button.getAttribute('data-kegiatan') || '';
        });

        setupModal('modalHapusGaleri', function(button) {
            var id = button.getAttribute('data-id');
            var judul = button.getAttribute('data-judul');
            document.getElementById('formHapusGaleri').action = '/admin/galeri/' + id;
            document.getElementById('hapus_judul_galeri').textContent = judul;
        });
    });
</script>
@endpush