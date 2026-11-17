@extends('admin.layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold" style="color: var(--hijau-tua);">Dashboard Admin</h2>
        <span class="text-muted"><i class="fas fa-calendar-alt"></i> {{ date('d F Y') }}</span>
    </div>

        <!-- KARTU STATISTIK UTAMA (GLOBAL) -->
    <div class="row mb-4">
        <div class="col-xl-2 col-md-4 mb-3">
            <div class="card border-0 shadow-sm h-100" style="border-left: 5px solid var(--hijau-tua) !important;">
                <div class="card-body p-3">
                    <h6 class="text-muted small">Siswa Aktif</h6>
                    <h3 class="fw-bold mb-0">{{ $totalSiswa }}</h3>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 mb-3">
            <div class="card border-0 shadow-sm h-100" style="border-left: 5px solid #0dcaf0 !important;">
                <div class="card-body p-3">
                    <h6 class="text-muted small">Total Pelatih</h6>
                    <h3 class="fw-bold mb-0">{{ $totalPelatih }}</h3>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 mb-3">
            <div class="card border-0 shadow-sm h-100" style="border-left: 5px solid #ffc107 !important;">
                <div class="card-body p-3">
                    <h6 class="text-muted small">Pendaftar Baru</h6>
                    <h3 class="fw-bold mb-0">{{ $pendaftarBaru }}</h3>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100" style="border-left: 5px solid #198754 !important;">
                <div class="card-body p-3">
                    <h6 class="text-muted small">Kas Masuk Hari Ini</h6>
                    <h3 class="fw-bold mb-0">Rp {{ number_format($kasHariIni, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card bg-primary text-white border-0 shadow-sm h-100">
                <div class="card-body p-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 small">Total Saldo Kas</h6>
                        <h3 class="fw-bold mb-0">Rp {{ number_format($saldo, 0, ',', '.') }}</h3>
                    </div>
                    <i class="fas fa-wallet fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- GRAFIK KEUANGAN -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 pb-0 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <h5 class="fw-bold mb-0" style="color: var(--hijau-tua);"><i class="fas fa-chart-bar"></i> Grafik Keuangan</h5>
                    
                    <!-- FILTER GRAFIK -->
                    <form action="/admin/dashboard" method="GET" class="d-flex align-items-center gap-2 bg-light p-2 rounded-3 border">
                        <span class="text-muted small fw-bold ms-1"><i class="fas fa-filter"></i> Filter:</span>
                        <select name="bulan_grafik" class="form-select form-select-sm border-0 shadow-sm" style="width: 110px;">
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}" {{ $bulanGrafik == $i ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($i)->translatedFormat('M') }}
                                </option>
                            @endfor
                        </select>
                        <select name="tahun_grafik" class="form-select form-select-sm border-0 shadow-sm" style="width: 90px;">
                            @for($i = date('Y') - 2; $i <= date('Y') + 1; $i++)
                                <option value="{{ $i }}" {{ $tahunGrafik == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                        <input type="hidden" name="bulan_analisis" value="{{ $bulanAnalisis }}">
                        <input type="hidden" name="tahun_analisis" value="{{ $tahunAnalisis }}">
                        <input type="hidden" name="bulan_siswa" value="{{ $bulanSiswa }}">
                        <input type="hidden" name="tahun_siswa" value="{{ $tahunSiswa }}">
                        <input type="hidden" name="bulan_log" value="{{ $bulanLog }}">
                        <input type="hidden" name="tahun_log" value="{{ $tahunLog }}">
                        <button type="submit" class="btn btn-sm btn-primary shadow-sm"><i class="fas fa-search"></i></button>
                    </form>
                </div>
                <div class="card-body">
                    <div style="position: relative; height: 320px; width: 100%;">
                        <canvas id="keuanganChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- ANALISIS KAS -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 pb-0 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <h5 class="fw-bold mb-0" style="color: var(--hijau-tua);"><i class="fas fa-chart-pie"></i> Analisis Kas</h5>
                    
                    <!-- FILTER ANALISIS -->
                    <form action="/admin/dashboard" method="GET" class="d-flex align-items-center gap-2 bg-light p-2 rounded-3 border">
                        <select name="bulan_analisis" class="form-select form-select-sm border-0 shadow-sm" style="width: 100px;">
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}" {{ $bulanAnalisis == $i ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($i)->translatedFormat('M') }}
                                </option>
                            @endfor
                        </select>
                        <select name="tahun_analisis" class="form-select form-select-sm border-0 shadow-sm" style="width: 80px;">
                            @for($i = date('Y') - 2; $i <= date('Y') + 1; $i++)
                                <option value="{{ $i }}" {{ $tahunAnalisis == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                        <input type="hidden" name="bulan_grafik" value="{{ $bulanGrafik }}">
                        <input type="hidden" name="tahun_grafik" value="{{ $tahunGrafik }}">
                        <input type="hidden" name="bulan_siswa" value="{{ $bulanSiswa }}">
                        <input type="hidden" name="tahun_siswa" value="{{ $tahunSiswa }}">
                        <input type="hidden" name="bulan_log" value="{{ $bulanLog }}">
                        <input type="hidden" name="tahun_log" value="{{ $tahunLog }}">
                        <button type="submit" class="btn btn-sm btn-primary shadow-sm"><i class="fas fa-search"></i></button>
                    </form>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-4">Analisis berdasarkan potensi maksimal iuran kas (Rp 5.000/siswa x 4 sesi/bulan).</p>
                    
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="fw-bold small text-muted">Potensi Maksimal</span>
                            <span class="fw-bold">Rp {{ number_format($potensiKas, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 text-success">
                            <span class="fw-bold small">Realisasi Terkumpul</span>
                            <span class="fw-bold">Rp {{ number_format($realisasiKas, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    <h6 class="fw-bold mb-2">Tingkat Realisasi: {{ number_format($persentaseRealisasi, 1) }}%</h6>
                    <div class="progress mb-3" style="height: 12px; border-radius: 10px;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated {{ $persentaseRealisasi >= 75 ? 'bg-success' : ($persentaseRealisasi >= 50 ? 'bg-warning' : 'bg-danger') }}" 
                             role="progressbar" style="width: {{ $persentaseRealisasi }}%; border-radius: 10px;"></div>
                    </div>
                    <div class="alert alert-{{ $persentaseRealisasi >= 75 ? 'success' : ($persentaseRealisasi >= 50 ? 'warning' : 'danger') }} py-2 px-3 small border-0 shadow-sm">
                        @if($persentaseRealisasi >= 75)
                            <i class="fas fa-check-circle"></i> <strong>Bagus!</strong> Kesadaran anggota membayar kas tinggi.
                        @elseif($persentaseRealisasi >= 50)
                            <i class="fas fa-exclamation-circle"></i> <strong>Cukup.</strong> Masih ada anggota yang sering absen/menunggak.
                        @else
                            <i class="fas fa-times-circle"></i> <strong>Perhatian!</strong> Banyak anggota belum membayar kas.
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- LOG AKTIVITAS (HANYA SUPER ADMIN) -->
    @if(Auth::user()->peran == 'super_admin')
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-4 pb-0 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <h5 class="fw-bold mb-0" style="color: var(--hijau-tua);"><i class="fas fa-list-alt"></i> Monitoring Aktivitas Terbaru</h5>
                    
                    <div class="d-flex align-items-center gap-3">
                        <!-- FILTER LOG AKTIVITAS -->
                        <form action="/admin/dashboard" method="GET" class="d-flex align-items-center gap-2 bg-light p-2 rounded-3 border">
                            <span class="text-muted small fw-bold ms-1"><i class="fas fa-filter"></i> Filter:</span>
                            <select name="bulan_log" class="form-select form-select-sm border-0 shadow-sm" style="width: 100px;">
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}" {{ $bulanLog == $i ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($i)->translatedFormat('M') }}
                                    </option>
                                @endfor
                            </select>
                            <select name="tahun_log" class="form-select form-select-sm border-0 shadow-sm" style="width: 80px;">
                                @for($i = date('Y') - 2; $i <= date('Y') + 1; $i++)
                                    <option value="{{ $i }}" {{ $tahunLog == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                            <!-- Sinkronisasi Filter Lain -->
                            <input type="hidden" name="bulan_grafik" value="{{ $bulanGrafik }}">
                            <input type="hidden" name="tahun_grafik" value="{{ $tahunGrafik }}">
                            <input type="hidden" name="bulan_analisis" value="{{ $bulanAnalisis }}">
                            <input type="hidden" name="tahun_analisis" value="{{ $tahunAnalisis }}">
                            <input type="hidden" name="bulan_siswa" value="{{ $bulanSiswa }}">
                            <input type="hidden" name="tahun_siswa" value="{{ $tahunSiswa }}">
                            <button type="submit" class="btn btn-sm btn-primary shadow-sm"><i class="fas fa-search"></i></button>
                        </form>
                        
                        <a href="/admin/log-aktivitas" class="btn btn-sm btn-outline-primary">Lihat Semua Log</a>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-hover align-middle table-sm">
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
                                <td>{{ $log->created_at->format('d M H:i') }}</td>
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
                                <td>{{ $log->modul }}</td>
                                <td>{{ $log->keterangan }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center text-muted py-4"><i class="fas fa-folder-open fa-2x mb-2 text-muted d-block"></i> Tidak ada aktivitas pada periode ini.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="row">
        <!-- SISWA PALING RAJIN -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 pb-0 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <h5 class="fw-bold mb-0" style="color: var(--hijau-tua);"><i class="fas fa-trophy text-warning"></i> Top 5 Siswa Paling Rajin</h5>
                    
                    <!-- FILTER SISWA -->
                    <form action="/admin/dashboard" method="GET" class="d-flex align-items-center gap-2 bg-light p-2 rounded-3 border">
                        <span class="text-muted small fw-bold ms-1"><i class="fas fa-filter"></i> Filter:</span>
                        <select name="bulan_siswa" class="form-select form-select-sm border-0 shadow-sm" style="width: 100px;">
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}" {{ $bulanSiswa == $i ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($i)->translatedFormat('M') }}
                                </option>
                            @endfor
                        </select>
                        <select name="tahun_siswa" class="form-select form-select-sm border-0 shadow-sm" style="width: 80px;">
                            @for($i = date('Y') - 2; $i <= date('Y') + 1; $i++)
                                <option value="{{ $i }}" {{ $tahunSiswa == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                        <input type="hidden" name="bulan_grafik" value="{{ $bulanGrafik }}">
                        <input type="hidden" name="tahun_grafik" value="{{ $tahunGrafik }}">
                        <input type="hidden" name="bulan_analisis" value="{{ $bulanAnalisis }}">
                        <input type="hidden" name="tahun_analisis" value="{{ $tahunAnalisis }}">
                        <input type="hidden" name="bulan_log" value="{{ $bulanLog }}">
                        <input type="hidden" name="tahun_log" value="{{ $tahunLog }}">
                        <button type="submit" class="btn btn-sm btn-primary shadow-sm"><i class="fas fa-search"></i></button>
                    </form>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @forelse($siswaRajin as $index => $sr)
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                                <div class="d-flex align-items-center">
                                    @if($index == 0)
                                        <span class="badge bg-warning text-dark me-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; font-size: 1rem;"><i class="fas fa-crown"></i></span>
                                    @elseif($index == 1)
                                        <span class="badge bg-secondary me-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; font-size: 1rem;">2</span>
                                    @elseif($index == 2)
                                        <span class="badge bg-danger me-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; font-size: 1rem;">3</span>
                                    @else
                                        <span class="badge bg-light text-dark border me-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; font-size: 1rem;">{{ $index + 1 }}</span>
                                    @endif
                                    
                                    <span class="fw-bold fs-6">{{ $sr->nama_siswa }}</span>
                                </div>
                                <span class="badge bg-success rounded-pill px-3 py-2">{{ $sr->absensi_count }} Kali Hadir</span>
                            </li>
                        @empty
                            <li class="list-group-item px-0 text-muted text-center py-4">
                                <i class="fas fa-folder-open fa-2x mb-2 text-muted"></i><br>
                                Belum ada data kehadiran untuk periode ini.
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <!-- TRANSAKSI TERBARU -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h5 class="fw-bold" style="color: var(--hijau-tua);"><i class="fas fa-history"></i> Transaksi Terbaru</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @forelse($transaksiTerbaru as $tt)
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
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
                            maxBarThickness: 24,
                            barPercentage: 0.8,
                            categoryPercentage: 0.8
                        },
                        {
                            label: 'Pengeluaran',
                            data: {!! json_encode($dataKeluar) !!},
                            backgroundColor: 'rgba(220, 53, 69, 0.85)',
                            hoverBackgroundColor: 'rgba(220, 53, 69, 1)',
                            borderRadius: 6,
                            maxBarThickness: 24,
                            barPercentage: 0.8,
                            categoryPercentage: 0.8
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: { padding: { top: 10, right: 10, bottom: 0, left: 0 } },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(0, 0, 0, 0.05)', drawBorder: false },
                            ticks: {
                                font: { size: 11 },
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
                            ticks: { font: { size: 11 } },
                            title: { display: true, text: 'Tanggal', color: '#6c757d', font: { size: 12, weight: 'bold' } }
                        }
                    },
                    plugins: {
                        legend: { position: 'top', labels: { usePointStyle: true, boxWidth: 8, font: { size: 12 } } },
                        tooltip: {
                            backgroundColor: 'rgba(0,0,0,0.8)', padding: 10,
                            titleFont: { size: 13 }, bodyFont: { size: 13 },
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