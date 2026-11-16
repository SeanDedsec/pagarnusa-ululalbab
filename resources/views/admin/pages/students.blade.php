@extends('admin.layouts.app')

@section('content')
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <strong>Gagal menyimpan!</strong> {{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold" style="color: var(--hijau-tua);">Data Siswa</h2>
        <div>
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

    <div class="card border-0 shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
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
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $s->nama_siswa }}</td>
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
                        <td>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalEdit"
                                data-id="{{ $s->id }}" 
                                data-nama="{{ $s->nama_siswa }}" 
                                data-alamat="{{ $s->alamat }}" 
                                data-hp="{{ $s->no_hp }}" 
                                data-tgl="{{ $s->tanggal_lahir }}"
                                data-status="{{ $s->status }}">
                                <i class="fas fa-edit"></i>
                            </button>

                            <button class="btn btn-sm btn-warning text-dark fw-bold" data-bs-toggle="modal" data-bs-target="#modalAbsensi"
                                data-id="{{ $s->id }}" 
                                data-nama="{{ $s->nama_siswa }}">
                                <i class="fas fa-clipboard-check"></i> Absen/Kas
                            </button>

                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapus"
                                data-id="{{ $s->id }}" 
                                data-nama="{{ $s->nama_siswa }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada data siswa.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modalTambah" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/admin/siswa" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Siswa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-2"><label>Nama Siswa</label><input type="text" name="nama_siswa" class="form-control" required></div>
                        <div class="mb-2"><label>Alamat</label><textarea name="alamat" class="form-control" required></textarea></div>
                        <div class="mb-2"><label>No HP</label><input type="number" name="no_hp" class="form-control" required></div>
                        <div class="mb-2"><label>Tanggal Lahir</label><input type="date" name="tanggal_lahir" class="form-control" required></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEdit" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <form id="formEdit" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Data Siswa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-2"><label>Nama Siswa</label><input type="text" name="nama_siswa" id="edit_nama" class="form-control" required></div>
                        <div class="mb-2"><label>Alamat</label><textarea name="alamat" id="edit_alamat" class="form-control" required></textarea></div>
                        <div class="mb-2"><label>No HP</label><input type="number" name="no_hp" id="edit_hp" class="form-control" required></div>
                        <div class="mb-2"><label>Tanggal Lahir</label><input type="date" name="tanggal_lahir" id="edit_tgl" class="form-control" required></div>
                        <div class="mb-2">
                            <label>Status</label>
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

    <div class="modal fade" id="modalHapus" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formHapus" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus data <strong id="hapus_nama"></strong>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAbsensi" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/admin/absensi" method="POST">
                    @csrf
                    <input type="hidden" name="siswa_id" id="absen_siswa_id">
                    
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title text-dark fw-bold">Absensi & Kas: <span id="absen_nama_siswa"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Pilih Jadwal Latihan</label>
                            <select name="jadwal_id" class="form-select" required>
                                <!-- Nanti kita isi otomatis dari database melalui Controller, sementara statis dulu -->
                                <option value="1">Minggu Sore (15:00 - 17:00)</option>
                                <option value="2">Kamis Sore (15:00 - 17:00)</option>
                                <option value="3">Senin Malam (19:00 - 21:00)</option>
                                <option value="4">Kamis Malam (19:00 - 21:00)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tanggal Latihan</label>
                            <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Status Kehadiran</label>
                            <select name="status_kehadiran" class="form-select" required>
                                <option value="hadir">Hadir</option>
                                <option value="izin">Izin</option>
                                <option value="sakit">Sakit</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nominal Kas (Rp)</label>
                            <!-- Default 5000, bisa diubah manual -->
                            <input type="number" name="nominal_kas" class="form-control" value="5000" required>
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
        // Fungsi pembantu untuk mencegah error jika modal tidak ditemukan
        function setupModal(modalId, callback) {
            var modal = document.getElementById(modalId);
            if (modal) {
                modal.addEventListener('show.bs.modal', function (event) {
                    var button = event.relatedTarget; // Tombol yang diklik
                    if (button) {
                        callback(button);
                    }
                });
            }
        }

        // 1. Setup Modal Edit
        setupModal('modalEdit', function(button) {
            var id = button.getAttribute('data-id');
            document.getElementById('formEdit').action = '/admin/siswa/' + id;
            document.getElementById('edit_nama').value = button.getAttribute('data-nama');
            document.getElementById('edit_alamat').value = button.getAttribute('data-alamat');
            document.getElementById('edit_hp').value = button.getAttribute('data-hp');
            document.getElementById('edit_tgl').value = button.getAttribute('data-tgl');
            document.getElementById('edit_status').value = button.getAttribute('data-status');
        });

        // 2. Setup Modal Hapus
        setupModal('modalHapus', function(button) {
            var id = button.getAttribute('data-id');
            var nama = button.getAttribute('data-nama');
            document.getElementById('formHapus').action = '/admin/siswa/' + id;
            document.getElementById('hapus_nama').textContent = nama;
        });

        // 3. Setup Modal Absensi (INI YANG KITA PERBAIKI)
        setupModal('modalAbsensi', function(button) {
            var id = button.getAttribute('data-id');
            var nama = button.getAttribute('data-nama');

            // Pastikan elemen ada sebelum mengisi nilai
            var inputId = document.getElementById('absen_siswa_id');
            var textNama = document.getElementById('absen_nama_siswa');
            
            if (inputId) {
                inputId.value = id;
            } else {
                console.error("Elemen input absen_siswa_id tidak ditemukan di HTML!");
            }

            if (textNama) {
                textNama.textContent = nama;
            }
        });
    });
</script>
@endpush