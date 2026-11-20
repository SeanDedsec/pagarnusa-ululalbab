@extends('admin.layouts.app')

@section('content')
    @php
        // Hitung filter yang terisi
        $jumlahFilter = collect(['nama', 'tanggal_mulai', 'tanggal_akhir', 'status'])->filter(fn($f) => request()->filled($f))->count();
    @endphp

    <style>
        /* ---------- Optimasi Ketajaman Teks ---------- */
        .abs-judul, .abs-tabel, .abs-filter {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
        }

        /* ---------- Riwayat Absensi ---------- */
        .abs-judul { font-size: clamp(1.3rem, 4vw, 1.8rem); margin: 0; letter-spacing: -0.5px; }

        /* Filter Toggle (HP) */
        .abs-filter-toggle {
            display: flex; align-items: center; gap: 10px; justify-content: center;
            background: #fff; border: 1.5px solid #dbe5df; color: #0f3d2e; font-weight: 600;
            border-radius: 12px; padding: 12px; margin-bottom: 10px;
        }
        .abs-filter-toggle:hover { background: #e8f1ec; color: #0f3d2e; }
        .abs-filter-toggle .jml { background: #1d6b4f; color: #fff; border-radius: 999px; font-size: .75rem; padding: 2px 9px; font-weight: 700; }
        .abs-filter-toggle .panah { transition: transform .2s; margin-left: auto; }
        .abs-filter-toggle[aria-expanded="true"] .panah { transform: rotate(180deg); }

        /* Filter Form */
        .abs-filter { background: #fff; border: 1px solid #dbe5df !important; border-radius: 14px; }
        .abs-filter .form-label { font-size: .85rem; font-weight: 600; margin-bottom: 5px; }
        .abs-filter .form-control, .abs-filter .form-select { font-size: 0.95rem; padding: 11px 13px; font-weight: 500; }
        .abs-filter .btn-primary { padding: 11px; font-weight: 600; }
        .abs-reset { display: inline-block; margin-top: 8px; font-size: .88rem; font-weight: 600; color: #5d6b64; text-decoration: none; }
        .abs-reset:hover { color: #b3322b; }

        /* Tabel */
        .abs-tabel th { font-weight: 700; color: #16241d; font-size: 0.85rem; letter-spacing: 0.3px; }
        .abs-tabel td { font-weight: 500; color: #333; font-size: 0.9rem; }
        .abs-tabel td.kas { font-weight: 700; font-variant-numeric: tabular-nums; white-space: nowrap; }
        .abs-tabel td.nama { color: #0f3d2e; font-weight: 600; }
        .abs-tabel .badge { padding: .45em .8em; border-radius: 999px; font-weight: 600; }
        .abs-tabel .badge.bg-success { background: #e8f1ec !important; color: #0f3d2e; }
        .abs-tabel .badge.bg-warning { background: #fff4d1 !important; color: #6b5200 !important; }
        .abs-tabel .badge.bg-info { background: #e3f0fa !important; color: #144a73 !important; }
        .abs-kosong { padding: 36px 12px !important; color: #5d6b64; font-weight: 500; }

        /* ---------- Tampilan Tabel di HP (Mobile) ---------- */
        @media (max-width: 767.98px) {
            /* Paksa tabel tetap berupa tabel dan bisa di-scroll */
            .abs-card-tabel .card-body { padding: 10px; }
            .abs-tabel { min-width: 850px; /* Lebar minimum agar kolom tidak berdesakan */ }
            
            .abs-tabel th, .abs-tabel td {
                font-size: 0.8rem; /* Perkecil font */
                padding: 8px 6px !important;
                white-space: nowrap; /* Cegah teks turun ke bawah */
            }
            
            .abs-tabel .badge { font-size: 0.7rem; padding: 0.3em 0.6em; }
        }
    </style>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold abs-judul" style="color: var(--hijau-tua);">Riwayat Absensi</h2>
    </div>

    <!-- FILTER TOGGLE (KHUSUS HP) -->
    <button class="btn abs-filter-toggle d-md-none w-100" type="button" data-bs-toggle="collapse" data-bs-target="#panelFilterAbsensi" aria-expanded="{{ $jumlahFilter ? 'true' : 'false' }}" aria-controls="panelFilterAbsensi">
        <i class="fas fa-filter"></i> Filter Riwayat Absensi
        @if($jumlahFilter)<span class="jml">{{ $jumlahFilter }}</span>@endif
        <i class="fas fa-chevron-down panah"></i>
    </button>

    <!-- FORM FILTER -->
    <div class="collapse d-md-block {{ $jumlahFilter ? 'show' : '' }}" id="panelFilterAbsensi">
        <div class="card border-0 shadow-sm mb-4 abs-filter">
            <div class="card-body">
                <form action="/admin/absensi" method="GET" class="row g-3 align-items-end">
                    <div class="col-12 col-md-3">
                        <label class="form-label" for="f_nama">Cari Nama Siswa</label>
                        <input type="text" id="f_nama" name="nama" class="form-control" placeholder="Ketik nama..." value="{{ request('nama') }}">
                    </div>
                    <div class="col-6 col-md-2">
                        <label class="form-label" for="f_mulai">Tanggal Mulai</label>
                        <input type="date" id="f_mulai" name="tanggal_mulai" class="form-control" value="{{ request('tanggal_mulai') }}">
                    </div>
                    <div class="col-6 col-md-2">
                        <label class="form-label" for="f_akhir">Tanggal Akhir</label>
                        <input type="date" id="f_akhir" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label" for="f_status">Status Kehadiran</label>
                        <select id="f_status" name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="hadir" {{ request('status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                            <option value="izin" {{ request('status') == 'izin' ? 'selected' : '' }}>Izin</option>
                            <option value="sakit" {{ request('status') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-2">
                        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i> Terapkan</button>
                    </div>
                </form>
                @if($jumlahFilter)
                    <a href="/admin/absensi" class="abs-reset"><i class="fas fa-rotate-left me-1"></i>Hapus semua filter</a>
                @endif
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm abs-card-tabel">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle abs-tabel mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Nama Siswa</th>
                        <th>Jadwal</th>
                        <th>Status</th>
                        <th>Kas Dibayar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($absensi as $index => $a)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($a->tanggal)->format('d M Y') }}</td>
                        
                        <!-- MENAMPILKAN WAKTU DARI CREATED_AT -->
                        <td>
                            <span class="text-muted"><i class="far fa-clock"></i> {{ $a->created_at ? $a->created_at->format('H:i:s') : '--:--:--' }}</span>
                        </td>
                        
                        <td class="nama">{{ $a->siswa->nama_siswa ?? 'Siswa Terhapus' }}</td>
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
                        <td class="kas">Rp {{ number_format($a->nominal_kas, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 abs-kosong">Tidak ada data absensi untuk filter ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection