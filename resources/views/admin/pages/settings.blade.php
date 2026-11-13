@extends('admin.layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold" style="color: var(--hijau-tua);">Pengaturan Sistem</h2>
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

    <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-bold" id="akun-tab" data-bs-toggle="tab" data-bs-target="#akun" type="button">
                <i class="fas fa-users-cog"></i> Kelola Akun Pengguna
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold" id="identitas-tab" data-bs-toggle="tab" data-bs-target="#identitas" type="button">
                <i class="fas fa-building"></i> Identitas Organisasi
            </button>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">

        <div class="tab-pane fade show active" id="akun" role="tabpanel">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0 fw-bold">Daftar Pengguna</h5>
                    <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalTambahUser">
                        <i class="fas fa-plus"></i> Tambah Akun
                    </button>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Lengkap</th>
                                <th>Username</th>
                                <th>Peran</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pengguna as $p)
                            <tr>
                                <td class="fw-bold">{{ $p->nama_lengkap }}</td>
                                <td>{{ $p->username }}</td>
                                <td>
                                    @if($p->peran == 'super_admin')
                                        <span class="badge bg-danger">Super Admin</span>
                                    @else
                                        <span class="badge bg-primary">Operator</span>
                                    @endif
                                </td>
                                <td>
                                    @if($p->status_akun == 'aktif')
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalEditUser"
                                        data-id="{{ $p->id }}" data-nama="{{ $p->nama_lengkap }}" data-peran="{{ $p->peran }}" data-status="{{ $p->status_akun }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    @if($p->id !== Auth::id())
                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapusUser"
                                        data-id="{{ $p->id }}" data-nama="{{ $p->nama_lengkap }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="identitas" role="tabpanel">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="/admin/pengaturan/identitas" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Organisasi</label>
                            <input type="text" name="nama_organisasi" class="form-control" value="{{ $identitas['nama_organisasi'] }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control" rows="3" required>{{ $identitas['alamat'] }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nomor HP / WhatsApp</label>
                            <input type="text" name="no_hp" class="form-control" value="{{ $identitas['no_hp'] }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Identitas</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalTambahUser" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/admin/pengaturan/user" method="POST">
                    @csrf
                    <div class="modal-header"><h5 class="modal-title">Tambah Akun Baru</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                    <div class="modal-body">
                        <div class="mb-2"><label>Nama Lengkap</label><input type="text" name="nama_lengkap" class="form-control" required></div>
                        <div class="mb-2"><label>Username</label><input type="text" name="username" class="form-control" required></div>
                        <div class="mb-2"><label>Password (Min 6 karakter)</label><input type="password" name="password" class="form-control" required></div>
                        <div class="mb-2">
                            <label>Peran</label>
                            <select name="peran" class="form-select" required>
                                <option value="operator">Operator</option>
                                <option value="super_admin">Super Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-success">Simpan</button></div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditUser" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formEditUser" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header"><h5 class="modal-title">Edit Akun Pengguna</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                    <div class="modal-body">
                        <div class="mb-2"><label>Nama Lengkap</label><input type="text" name="nama_lengkap" id="edit_nama_user" class="form-control" required></div>
                        <div class="mb-2"><label>Password Baru (Kosongkan jika tidak diganti)</label><input type="password" name="password" class="form-control"></div>
                        <div class="mb-2">
                            <label>Peran</label>
                            <select name="peran" id="edit_peran_user" class="form-select" required>
                                <option value="operator">Operator</option>
                                <option value="super_admin">Super Admin</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label>Status Akun</label>
                            <select name="status_akun" id="edit_status_user" class="form-select" required>
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Update</button></div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalHapusUser" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formHapusUser" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header"><h5 class="modal-title">Konfirmasi Hapus</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus akun <strong id="hapus_nama_user"></strong>?</p>
                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-danger">Hapus</button></div>
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

        setupModal('modalEditUser', function(button) {
            var id = button.getAttribute('data-id');
            document.getElementById('formEditUser').action = '/admin/pengaturan/user/' + id;
            document.getElementById('edit_nama_user').value = button.getAttribute('data-nama');
            document.getElementById('edit_peran_user').value = button.getAttribute('data-peran');
            document.getElementById('edit_status_user').value = button.getAttribute('data-status');
        });

        setupModal('modalHapusUser', function(button) {
            var id = button.getAttribute('data-id');
            var nama = button.getAttribute('data-nama');
            document.getElementById('formHapusUser').action = '/admin/pengaturan/user/' + id;
            document.getElementById('hapus_nama_user').textContent = nama;
        });
    });
</script>
@endpush