@extends('admin.layouts.app')

@section('content')
    <style>
        /* ---------- Gaya Filter Dropdown ---------- */
        .btn-filter-toggle { background: #fff; border: 1px solid var(--garis); color: var(--hijau-tua); font-weight: 600; font-size: 0.85rem; border-radius: 8px; padding: 6px 12px; }
        .btn-filter-toggle:hover { background: var(--hijau-pucat); }
        .filter-box { background: #f8f9fa; border: 1px solid var(--garis); border-radius: 10px; padding: 15px; margin-top: 10px; }
        
        /* ---------- Optimasi Khusus HP ---------- */
        @media (max-width: 767.98px) {
            .dashboard-judul { font-size: 1.3rem; }
            .stat-card { padding: 12px !important; }
            .stat-card h6 { font-size: 0.75rem; margin-bottom: 2px; }
            .stat-card h3 { font-size: 1.1rem; }
            
            .log-table th:nth-child(4), 
            .log-table td:nth-child(4) { display: none; }
            .log-table th, .log-table td { font-size: 0.8rem; padding: 8px 4px !important; }

            .list-group-item { padding: 12px 0 !important; }
            .badge-hadir { font-size: 0.7rem; padding: 4px 8px !important; }
            .avatar-rank { width: 30px !important; height: 30px !important; font-size: 0.85rem !important; margin-right: 10px !important; }
            .nama-siswa { font-size: 0.9rem !important; }
            
            .chart-container { height: 280px !important; }
            
            /* Pagination lebih kecil di HP */
            .pagination { --bs-pagination-padding-x: 0.5rem; --bs-pagination-padding-y: 0.25rem; --bs-pagination-font-size: 0.8rem; }
        }
    </style>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold dashboard-judul" style="color: var(--hijau-tua);">Dashboard Admin</h2>
        <span class="text-muted small"><i class="fas fa-calendar-alt"></i> {{ date('d M Y') }}</span>
    </div>

    <!-- KARTU STATISTIK UTAMA (GLOBAL) -->
    <div class="row g-2 mb-4">
        <div class="col-6 col-md-4 col-xl">
            <div class="card border-0 shadow-sm h-100 stat-card" style="border-left: 4px solid var(--hijau-tua) !important;">
                <div class="card-body p-3">
                    <h6 class="text-muted">Siswa Aktif</h6>
                    <h3 class="fw-bold mb-0">{{ $totalSiswa }}</h3>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl">
            <div class="card border-0 shadow-sm h-100 stat-card" style="border-left: 4px solid #0dcaf0 !important;">
                <div class="card-body p-3">
                    <h6 class="text-muted">Total Pelatih</h6>
                    <h3 class="fw-bold mb-0">{{ $totalPelatih }}</h3>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl">
            <div class="card border-0 shadow-sm h-100 stat-card" style="border-left: 4px solid #ffc107 !important;">
                <div class="card-body p-3">
                    <h6 class="text-muted">Pendaftar Baru</h6>
                    <h3 class="fw-bold mb-0">{{ $pendaftarBaru }}</h3>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-6 col-xl">
            <div class="card border-0 shadow-sm h-100 stat-card" style="border-left: 4px solid #198754 !important;">
                <div class="card-body p-3">
                    <h6 class="text-muted">Kas Masuk Hari Ini</h6>
                    <h3 class="fw-bold mb-0">Rp {{ number_format($kasHariIni, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl">
            <div class="card bg-primary text-white border-0 shadow-sm h-100 stat-card">
                <div class="card-body p-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50">Total Saldo Kas</h6>
                        <h3 class="fw-bold mb-0">Rp {{ number_format($saldo, 0, ',', '.') }}</h3>
                    </div>
                    <i class="fas fa-wallet fa-2x opacity-50 d-none d-sm-block"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <!-- GRAFIK KEUANGAN -->
        <div class="col-lg-8 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-3 pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 fs-6" style="color: var(--hijau-tua);"><i class="fas fa-chart-bar"></i> Grafik Keuangan</h5>
                    
                    <button class="btn btn-filter-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#filterGrafik" aria-expanded="false">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </div>
                
                <div class="collapse" id="filterGrafik">
                    <div class="px-3">
                        <div class="filter-box">
                            <form action="/admin/dashboard" method="GET" class="row g-2 align-items-end">
                                <div class="col-6 col-md-4">
                                    <label class="form-label small mb-1">Bulan</label>
                                    <select name="bulan_grafik" class="form-select form-select-sm">
                                        @for($i = 1; $i <= 12; $i++)
                                            <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}" {{ $bulanGrafik == $i ? 'selected' : '' }}>
                                                {{ \Carbon\Carbon::create()->month($i)->translatedFormat('M') }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-6 col-md-4">
                                    <label class="form-label small mb-1">Tahun</label>
                                    <select name="tahun_grafik" class="form-select form-select-sm">
                                        @for($i = date('Y') - 2; $i <= date('Y') + 1; $i++)
                                            <option value="{{ $i }}" {{ $tahunGrafik == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-12 col-md-4">
                                    <button type="submit" class="btn btn-sm btn-primary w-100">Terapkan</button>
                                </div>
                                <!-- Hidden Inputs -->
                                <input type="hidden" name="bulan_analisis" value="{{ $bulanAnalisis }}"><input type="hidden" name="tahun_analisis" value="{{ $tahunAnalisis }}">
                                <input type="hidden" name="bulan_siswa" value="{{ $bulanSiswa }}"><input type="hidden" name="tahun_siswa" value="{{ $tahunSiswa }}">
                                <input type="hidden" name="bulan_log" value="{{ $bulanLog }}"><input type="hidden" name="tahun_log" value="{{ $tahunLog }}">
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height: 300px; width: 100%;">
                        <canvas id="keuanganChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- ANALISIS KAS -->
        <div class="col-lg-4 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-3 pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 fs-6" style="color: var(--hijau-tua);"><i class="fas fa-chart-pie"></i> Analisis Kas</h5>
                    
                    <button class="btn btn-filter-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#filterAnalisis" aria-expanded="false">
                        <i class="fas fa-filter"></i>
                    </button>
                </div>

                <div class="collapse" id="filterAnalisis">
                    <div class="px-3">
                        <div class="filter-box">
                            <form action="/admin/dashboard" method="GET" class="row g-2 align-items-end">
                                <div class="col-6">
                                    <label class="form-label small mb-1">Bulan</label>
                                    <select name="bulan_analisis" class="form-select form-select-sm">
                                        @for($i = 1; $i <= 12; $i++)
                                            <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}" {{ $bulanAnalisis == $i ? 'selected' : '' }}>
                                                {{ \Carbon\Carbon::create()->month($i)->translatedFormat('M') }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label class="form-label small mb-1">Tahun</label>
                                    <select name="tahun_analisis" class="form-select form-select-sm">
                                        @for($i = date('Y') - 2; $i <= date('Y') + 1; $i++)
                                            <option value="{{ $i }}" {{ $tahunAnalisis == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-12 mt-2">
                                    <button type="submit" class="btn btn-sm btn-primary w-100">Terapkan</button>
                                </div>
                                <!-- Hidden Inputs -->
                                <input type="hidden" name="bulan_grafik" value="{{ $bulanGrafik }}"><input type="hidden" name="tahun_grafik" value="{{ $tahunGrafik }}">
                                <input type="hidden" name="bulan_siswa" value="{{ $bulanSiswa }}"><input type="hidden" name="tahun_siswa" value="{{ $tahunSiswa }}">
                                <input type="hidden" name="bulan_log" value="{{ $bulanLog }}"><input type="hidden" name="tahun_log" value="{{ $tahunLog }}">
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card-body pt-2">
                    <p class="text-muted small mb-3">Analisis potensi iuran kas (Rp 5.000/siswa x 4 sesi).</p>
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="fw-bold small text-muted">Potensi</span>
                            <span class="fw-bold small">Rp {{ number_format($potensiKas, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-1 text-success">
                            <span class="fw-bold small">Realisasi</span>
                            <span class="fw-bold small">Rp {{ number_format($realisasiKas, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    <h6 class="fw-bold mb-1 small">Tingkat Realisasi: {{ number_format($persentaseRealisasi, 1) }}%</h6>
                    <div class="progress mb-3" style="height: 10px; border-radius: 10px;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated {{ $persentaseRealisasi >= 75 ? 'bg-success' : ($persentaseRealisasi >= 50 ? 'bg-warning' : 'bg-danger') }}" 
                             role="progressbar" style="width: {{ $persentaseRealisasi }}%; border-radius: 10px;"></div>
                    </div>
                    <div class="alert alert-{{ $persentaseRealisasi >= 75 ? 'success' : ($persentaseRealisasi >= 50 ? 'warning' : 'danger') }} py-2 px-3 small border-0 shadow-sm mb-0">
                        @if($persentaseRealisasi >= 75)
                            <i class="fas fa-check-circle"></i> <strong>Bagus!</strong> Kas terkumpul dengan baik.
                        @elseif($persentaseRealisasi >= 50)
                            <i class="fas fa-exclamation-circle"></i> <strong>Cukup.</strong> Masih ada yang menunggak.
                        @else
                            <i class="fas fa-times-circle"></i> <strong>Perhatian!</strong> Banyak belum bayar kas.
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- LOG AKTIVITAS (HANYA SUPER ADMIN) -->
    @if(Auth::user()->peran == 'super_admin')
    <div class="row mt-3">
        <div class="col-12 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-3 pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 fs-6" style="color: var(--hijau-tua);"><i class="fas fa-list-alt"></i> Monitoring Aktivitas</h5>
                    
                    <div class="d-flex gap-2">
                        <button class="btn btn-filter-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#filterLog" aria-expanded="false">
                            <i class="fas fa-filter"></i>
                        </button>
                        <a href="/admin/log-aktivitas" class="btn btn-sm btn-outline-primary d-none d-md-inline-block">Lihat Semua</a>
                    </div>
                </div>

                <div class="collapse" id="filterLog">
                    <div class="px-3">
                        <div class="filter-box">
                            <form action="/admin/dashboard" method="GET" class="row g-2 align-items-end">
                                <div class="col-6 col-md-4">
                                    <label class="form-label small mb-1">Bulan</label>
                                    <select name="bulan_log" class="form-select form-select-sm">
                                        @for($i = 1; $i <= 12; $i++)
                                            <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}" {{ $bulanLog == $i ? 'selected' : '' }}>
                                                {{ \Carbon\Carbon::create()->month($i)->translatedFormat('M') }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-6 col-md-4">
                                    <label class="form-label small mb-1">Tahun</label>
                                    <select name="tahun_log" class="form-select form-select-sm">
                                        @for($i = date('Y') - 2; $i <= date('Y') + 1; $i++)
                                            <option value="{{ $i }}" {{ $tahunLog == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-12 col-md-4">
                                    <button type="submit" class="btn btn-sm btn-primary w-100">Terapkan</button>
                                </div>
                                <!-- Hidden Inputs -->
                                <input type="hidden" name="bulan_grafik" value="{{ $bulanGrafik }}"><input type="hidden" name="tahun_grafik" value="{{ $tahunGrafik }}">
                                <input type="hidden" name="bulan_analisis" value="{{ $bulanAnalisis }}"><input type="hidden" name="tahun_analisis" value="{{ $tahunAnalisis }}">
                                <input type="hidden" name="bulan_siswa" value="{{ $bulanSiswa }}"><input type="hidden" name="tahun_siswa" value="{{ $tahunSiswa }}">
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive pt-2">
                    <table class="table table-hover align-middle table-sm log-table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Waktu</th>
                                <th>Pengguna</th>
                                <th>Aksi</th>
                                <th class="d-none d-md-table-cell">Modul</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $log)
                            <tr>
                                <td class="text-nowrap">{{ $log->created_at->format('d M H:i') }}</td>
                                <td class="fw-bold">{{ $log->pengguna->nama_lengkap ?? 'Sistem' }}</td>
                                <td>
                                    @if($log->aksi == 'Login') <span class="badge bg-primary">Login</span>
                                    @elseif($log->aksi == 'Logout') <span class="badge bg-secondary">Logout</span>
                                    @elseif($log->aksi == 'Tambah') <span class="badge bg-success">Tambah</span>
                                    @elseif($log->aksi == 'Edit') <span class="badge bg-warning text-dark">Edit</span>
                                    @elseif($log->aksi == 'Hapus') <span class="badge bg-danger">Hapus</span>
                                    @else <span class="badge bg-info text-dark">{{ $log->aksi }}</span>
                                    @endif
                                </td>
                                <td class="d-none d-md-table-cell">{{ $log->modul }}</td>
                                <td>{{ Str::limit($log->keterangan, 20) }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center text-muted py-4"><i class="fas fa-folder-open fa-2x mb-2 text-muted d-block"></i> Tidak ada aktivitas.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                    
                    <div class="d-flex justify-content-center mt-3">
                        {{ $logs->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="row g-3 mt-1">
        <!-- SISWA PALING RAJIN -->
        <div class="col-lg-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-3 pb-0 d-flex justify-content-between align-items-center">
                    <!-- Ubah Judul -->
                    <h5 class="fw-bold mb-0 fs-6" style="color: var(--hijau-tua);"><i class="fas fa-trophy text-warning"></i> Siswa Paling Rajin</h5>
                    
                    <button class="btn btn-filter-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#filterSiswa" aria-expanded="false">
                        <i class="fas fa-filter"></i>
                    </button>
                </div>

                <div class="collapse" id="filterSiswa">
                    <div class="px-3">
                        <div class="filter-box">
                            <form action="/admin/dashboard" method="GET" class="row g-2 align-items-end">
                                <div class="col-6">
                                    <label class="form-label small mb-1">Bulan</label>
                                    <select name="bulan_siswa" class="form-select form-select-sm">
                                        @for($i = 1; $i <= 12; $i++)
                                            <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}" {{ $bulanSiswa == $i ? 'selected' : '' }}>
                                                {{ \Carbon\Carbon::create()->month($i)->translatedFormat('M') }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label class="form-label small mb-1">Tahun</label>
                                    <select name="tahun_siswa" class="form-select form-select-sm">
                                        @for($i = date('Y') - 2; $i <= date('Y') + 1; $i++)
                                            <option value="{{ $i }}" {{ $tahunSiswa == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-12 mt-2">
                                    <button type="submit" class="btn btn-sm btn-primary w-100">Terapkan</button>
                                </div>
                                <!-- Hidden Inputs -->
                                <input type="hidden" name="bulan_grafik" value="{{ $bulanGrafik }}"><input type="hidden" name="tahun_grafik" value="{{ $tahunGrafik }}">
                                <input type="hidden" name="bulan_analisis" value="{{ $bulanAnalisis }}"><input type="hidden" name="tahun_analisis" value="{{ $tahunAnalisis }}">
                                <input type="hidden" name="bulan_log" value="{{ $bulanLog }}"><input type="hidden" name="tahun_log" value="{{ $tahunLog }}">
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card-body pt-2">
                    <ul class="list-group list-group-flush">
                        @forelse($siswaRajin as $index => $sr)
                            <!-- Menghitung Ranking Sebenarnya meskipun pindah halaman -->
                            @php $trueRank = $siswaRajin->firstItem() + $index; @endphp
                            
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                                <div class="d-flex align-items-center">
                                    @if($trueRank == 1)
                                        <span class="badge bg-warning text-dark me-2 rounded-circle d-flex align-items-center justify-content-center avatar-rank" style="width: 35px; height: 35px; font-size: 1rem;"><i class="fas fa-crown"></i></span>
                                    @elseif($trueRank == 2)
                                        <span class="badge bg-secondary me-2 rounded-circle d-flex align-items-center justify-content-center avatar-rank" style="width: 35px; height: 35px; font-size: 1rem;">2</span>
                                    @elseif($trueRank == 3)
                                        <span class="badge bg-danger me-2 rounded-circle d-flex align-items-center justify-content-center avatar-rank" style="width: 35px; height: 35px; font-size: 1rem;">3</span>
                                    @else
                                        <span class="badge bg-light text-dark border me-2 rounded-circle d-flex align-items-center justify-content-center avatar-rank" style="width: 35px; height: 35px; font-size: 1rem;">{{ $trueRank }}</span>
                                    @endif
                                    
                                    <span class="fw-bold nama-siswa" style="font-size: 1.05rem;">{{ $sr->nama_siswa }}</span>
                                </div>
                                <span class="badge bg-success rounded-pill badge-hadir px-3 py-2">{{ $sr->absensi_count }} Hadir</span>
                            </li>
                        @empty
                            <li class="list-group-item px-0 text-muted text-center py-4">
                                <i class="fas fa-folder-open fa-2x mb-2 text-muted"></i><br>
                                Belum ada data kehadiran.
                            </li>
                        @endforelse
                    </ul>
                    
                    <!-- Pagination Siswa -->
                    @if($siswaRajin->hasPages())
                    <div class="d-flex justify-content-center mt-3">
                        {{ $siswaRajin->links('pagination::bootstrap-5') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- TRANSAKSI TERBARU -->
        <div class="col-lg-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-3 pb-0">
                    <h5 class="fw-bold fs-6 mb-0" style="color: var(--hijau-tua);"><i class="fas fa-history"></i> Transaksi Terbaru</h5>
                </div>
                <div class="card-body pt-2">
                    <ul class="list-group list-group-flush">
                        @forelse($transaksiTerbaru as $tt)
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                                <div>
                                    <small class="text-muted" style="font-size: 0.75rem;">{{ \Carbon\Carbon::parse($tt->tanggal)->format('d M Y') }}</small><br>
                                    <span class="fw-bold" style="font-size: 0.95rem;">{{ $tt->kategori }}</span>
                                </div>
                                <span class="fw-bold {{ $tt->jenis_transaksi == 'masuk' ? 'text-success' : 'text-danger' }}" style="font-size: 0.95rem;">
                                    {{ $tt->jenis_transaksi == 'masuk' ? '+' : '-' }} Rp {{ number_format($tt->nominal, 0, ',', '.') }}
                                </span>
                            </li>
                        @empty
                            <li class="list-group-item px-0 text-muted text-center py-4">Belum ada transaksi.</li>
                        @endforelse
                    </ul>
                    
                    <!-- Pagination Transaksi -->
                    @if($transaksiTerbaru->hasPages())
                    <div class="d-flex justify-content-center mt-3">
                        {{ $transaksiTerbaru->links('pagination::bootstrap-5') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPT CHART JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('keuanganChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($labels) !!},
                    datasets: [
                        {
                            label: 'Pemasukan',
                            data: {!! json_encode($dataMasuk) !!},
                            backgroundColor: 'rgba(25, 135, 84, 0.85)',
                            hoverBackgroundColor: 'rgba(25, 135, 84, 1)',
                            borderRadius: 6, 
                            maxBarThickness: 45, 
                            barPercentage: 0.9,  
                            categoryPercentage: 0.8 
                        },
                        {
                            label: 'Pengeluaran',
                            data: {!! json_encode($dataKeluar) !!},
                            backgroundColor: 'rgba(220, 53, 69, 0.85)',
                            hoverBackgroundColor: 'rgba(220, 53, 69, 1)',
                            borderRadius: 6,
                            maxBarThickness: 45, 
                            barPercentage: 0.9,
                            categoryPercentage: 0.8
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: { padding: { top: 5, right: 5, bottom: 0, left: 0 } },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(0, 0, 0, 0.05)', drawBorder: false },
                            ticks: {
                                font: { size: 10 }, 
                                callback: function(value) {
                                    if (value === 0) return '0';
                                    if (value >= 1000000) return 'Rp ' + (value / 1000000) + 'jt';
                                    if (value >= 1000) return 'Rp ' + (value / 1000) + 'rb';
                                    return 'Rp ' + value;
                                }
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 10 } },
                            title: { display: true, text: 'Tanggal', color: '#6c757d', font: { size: 11, weight: 'bold' } }
                        }
                    },
                    plugins: {
                        legend: { 
                            position: 'top', 
                            labels: { usePointStyle: true, boxWidth: 8, font: { size: 11 } } 
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0,0,0,0.8)', padding: 10,
                            titleFont: { size: 12 }, bodyFont: { size: 12 },
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': Rp ' + context.parsed.y.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection