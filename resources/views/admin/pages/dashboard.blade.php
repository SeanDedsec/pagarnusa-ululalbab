@extends('admin.layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold" style="color: var(--hijau-tua);">Dashboard Admin</h2>
        <span class="text-muted"><i class="fas fa-calendar-alt"></i> {{ date('d F Y') }}</span>
    </div>

    <!-- KARTU STATISTIK UTAMA -->
    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100" style="border-left: 5px solid var(--hijau-tua) !important;">
                <div class="card-body">
                    <h6 class="text-muted">Siswa Aktif</h6>
                    <h3 class="fw-bold">{{ $totalSiswa }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100" style="border-left: 5px solid #ffc107 !important;">
                <div class="card-body">
                    <h6 class="text-muted">Pendaftar Baru</h6>
                    <h3 class="fw-bold">{{ $pendaftarBaru }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card bg-primary text-white border-0 shadow-sm h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50">Saldo Kas Organisasi</h6>
                        <h2 class="fw-bold mb-0">Rp {{ number_format($saldo, 0, ',', '.') }}</h2>
                    </div>
                    <i class="fas fa-wallet fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <!-- SISWA PALING RAJIN -->
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h5 class="fw-bold" style="color: var(--hijau-tua);"><i class="fas fa-trophy text-warning"></i> Siswa Paling Rajin Hadir</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @forelse($siswaRajin as $index => $sr)
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <span class="badge bg-secondary me-2">{{ $index + 1 }}</span>
                                    <span class="fw-bold">{{ $sr->nama_siswa }}</span>
                                </div>
                                <span class="badge bg-success rounded-pill">{{ $sr->absensi_count }} Kali Hadir</span>
                            </li>
                        @empty
                            <li class="list-group-item px-0 text-muted">Belum ada data kehadiran.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <!-- TRANSAKSI TERBARU -->
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h5 class="fw-bold" style="color: var(--hijau-tua);"><i class="fas fa-history"></i> Transaksi Terbaru</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @forelse($transaksiTerbaru as $tt)
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($tt->tanggal)->format('d M Y') }}</small><br>
                                    <span class="fw-bold">{{ $tt->kategori }}</span>
                                </div>
                                <span class="fw-bold {{ $tt->jenis_transaksi == 'masuk' ? 'text-success' : 'text-danger' }}">
                                    {{ $tt->jenis_transaksi == 'masuk' ? '+' : '-' }} Rp {{ number_format($tt->nominal, 0, ',', '.') }}
                                </span>
                            </li>
                        @empty
                            <li class="list-group-item px-0 text-muted">Belum ada transaksi.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection