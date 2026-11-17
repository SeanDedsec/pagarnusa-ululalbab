@extends('admin.layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold" style="color: var(--hijau-tua);">Log Aktivitas</h2>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Waktu</th>
                        <th>Pengguna</th>
                        <th>Aksi</th>
                        <th>Modul</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr>
                        <td>{{ $log->created_at->format('d M Y, H:i') }}</td>
                        <td class="fw-bold">{{ $log->pengguna->nama_lengkap ?? 'Sistem' }}</td>
                        <td>
                            @if($log->aksi == 'Login')
                                <span class="badge bg-primary">Login</span>
                            @elseif($log->aksi == 'Logout')
                                <span class="badge bg-secondary">Logout</span>
                            @elseif($log->aksi == 'Tambah')
                                <span class="badge bg-success">Tambah</span>
                            @elseif($log->aksi == 'Edit')
                                <span class="badge bg-warning text-dark">Edit</span>
                            @elseif($log->aksi == 'Hapus')
                                <span class="badge bg-danger">Hapus</span>
                            @else
                                <span class="badge bg-info text-dark">{{ $log->aksi }}</span>
                            @endif
                        </td>
                        <td>{{ $log->modul }}</td>
                        <td>{{ $log->keterangan }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">Belum ada log aktivitas.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- BAGIAN PAGINATION -->
        @if($logs->hasPages())
        <div class="card-footer bg-white border-0 pt-0 pb-3 d-flex justify-content-center">
            {{ $logs->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
@endsection