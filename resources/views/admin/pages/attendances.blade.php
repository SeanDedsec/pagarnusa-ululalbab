@extends('admin.layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold" style="color: var(--hijau-tua);">Riwayat Absensi</h2>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="/admin/absensi" method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Cari Nama Siswa</label>
                    <input type="text" name="nama" class="form-control" placeholder="Ketik nama..." value="{{ request('nama') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" class="form-control" value="{{ request('tanggal_mulai') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Tanggal Akhir</label>
                    <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status Kehadiran</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="hadir" {{ request('status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                        <option value="izin" {{ request('status') == 'izin' ? 'selected' : '' }}>Izin</option>
                        <option value="sakit" {{ request('status') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i> Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Nama Siswa</th>
                        <th>Jadwal</th>
                        <th>Status</th>
                        <th>Kas Dibayar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($absensi as $a)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($a->tanggal)->format('d M Y') }}</td>
                        <td class="fw-bold">{{ $a->siswa->nama_siswa ?? 'Siswa Terhapus' }}</td>
                        <td>{{ $a->jadwal->hari ?? '-' }} ({{ $a->jadwal->keterangan ?? '-' }})</td>
                        <td>
                            @if($a->status_kehadiran == 'hadir')
                                <span class="badge bg-success"><i class="fas fa-check"></i> Hadir</span>
                            @elseif($a->status_kehadiran == 'izin')
                                <span class="badge bg-warning text-dark">Izin</span>
                            @else
                                <span class="badge bg-info text-dark">Sakit</span>
                            @endif
                        </td>
                        <td>Rp {{ number_format($a->nominal_kas, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">Tidak ada data absensi untuk filter ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection