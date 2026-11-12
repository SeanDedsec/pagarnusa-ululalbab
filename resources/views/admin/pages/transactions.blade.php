@extends('admin.layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold" style="color: var(--hijau-tua);">Kelola Keuangan</h2>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambahKeuangan">
            <i class="fas fa-plus"></i> Catat Transaksi
        </button>
    </div>

    @if(session('sukses'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('sukses') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-success text-white border-0 shadow-sm">
                <div class="card-body">
                    <h6>Total Pemasukan</h6>
                    <h3 class="fw-bold">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-danger text-white border-0 shadow-sm">
                <div class="card-body">
                    <h6>Total Pengeluaran</h6>
                    <h3 class="fw-bold">Rp {{ number_format($totalKeluar, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-primary text-white border-0 shadow-sm">
                <div class="card-body">
                    <h6>Saldo Akhir</h6>
                    <h3 class="fw-bold">Rp {{ number_format($saldo, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Kategori</th>
                        <th>Jenis</th>
                        <th>Nominal</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($keuangan as $k)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($k->tanggal)->format('d M Y') }}</td>
                        <td>{{ $k->kategori }}</td>
                        <td>
                            @if($k->jenis_transaksi == 'masuk')
                                <span class="badge bg-success">Masuk</span>
                            @else
                                <span class="badge bg-danger">Keluar</span>
                            @endif
                        </td>
                        <td>Rp {{ number_format($k->nominal, 0, ',', '.') }}</td>
                        <td>{{ $k->keterangan ?? '-' }}</td>
                        <td>
                            <!-- Tombol Hapus -->
                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapusKeuangan"
                                data-id="{{ $k->id }}" 
                                data-kategori="{{ $k->kategori }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada data transaksi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modalTambahKeuangan" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/admin/keuangan" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Catat Transaksi Manual</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-2">
                            <label>Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="mb-2">
                            <label>Jenis Transaksi</label>
                            <select name="jenis_transaksi" class="form-select" required>
                                <option value="masuk">Uang Masuk (Pemasukan)</option>
                                <option value="keluar">Uang Keluar (Pengeluaran)</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label>Kategori</label>
                            <input type="text" name="kategori" class="form-control" placeholder="Contoh: Beli Air Minum, Donasi" required>
                        </div>
                        <div class="mb-2">
                            <label>Nominal (Rp)</label>
                            <input type="number" name="nominal" class="form-control" placeholder="Contoh: 15000" required>
                        </div>
                        <div class="mb-2">
                            <label>Keterangan (Opsional)</label>
                            <textarea name="keterangan" class="form-control" rows="2"></textarea>
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

    <div class="modal fade" id="modalHapusKeuangan" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formHapusKeuangan" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
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