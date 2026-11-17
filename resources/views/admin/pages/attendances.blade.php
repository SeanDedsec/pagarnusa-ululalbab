@extends('admin.layouts.app')

@section('content')
    <style>
        /* ---------- Riwayat Absensi ---------- */
        .abs-judul { font-size: clamp(1.4rem, 4vw, 1.8rem); margin: 0; }

        /* Filter */
        .abs-filter { background: #fff; border: 1px solid #dbe5df !important; border-radius: 14px; }
        .abs-filter .form-label { font-size: .85rem; margin-bottom: 5px; }
        .abs-filter .form-control, .abs-filter .form-select { font-size: 1rem; padding: 11px 13px; }
        .abs-filter .btn-primary { padding: 11px; }
        .abs-reset { display: inline-block; margin-top: 8px; font-size: .88rem; font-weight: 600; color: #5d6b64; text-decoration: none; }
        .abs-reset:hover { color: #b3322b; }

        /* Tabel */
        .abs-tabel td.kas { font-weight: 700; font-variant-numeric: tabular-nums; white-space: nowrap; }
        .abs-tabel td.nama { color: #0f3d2e; }
        .abs-tabel .badge { padding: .45em .8em; border-radius: 999px; }
        .abs-tabel .badge.bg-success { background: #e8f1ec !important; color: #0f3d2e; }
        .abs-tabel .badge.bg-warning { background: #fff4d1 !important; color: #6b5200 !important; }
        .abs-tabel .badge.bg-info { background: #e3f0fa !important; color: #144a73 !important; }
        .abs-kosong { padding: 36px 12px !important; color: #5d6b64; }

        /* Tabel jadi kartu di HP */
        @media (max-width: 767.98px) {
            .abs-tabel thead { display: none; }
            .abs-tabel, .abs-tabel tbody, .abs-tabel tr, .abs-tabel td { display: block; width: 100%; }
            .abs-tabel tbody tr { border: 1px solid #dbe5df; border-radius: 12px; margin-bottom: 12px; padding: 6px 14px; background: #fff; }
            .abs-tabel td { display: flex; justify-content: space-between; align-items: center; gap: 16px; padding: 9px 0 !important; border: 0; border-bottom: 1px dashed #e3ebe6; text-align: right; }
            .abs-tabel td:last-child { border-bottom: 0; }
            .abs-tabel td::before { content: attr(data-label); font-size: .8rem; font-weight: 600; color: #5d6b64; text-align: left; flex-shrink: 0; }
            .abs-tabel td.nama { font-size: 1.05rem; }
            .abs-tabel td.abs-kosong { display: block; text-align: center; }
            .abs-tabel td.abs-kosong::before { content: none; }
            .abs-card-tabel { background: transparent !important; border: 0 !important; }
            .abs-card-tabel .card-body { padding: 0; }
        }
    </style>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold abs-judul" style="color: var(--hijau-tua);">Riwayat Absensi</h2>
    </div>

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
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i> Filter</button>
                </div>
            </form>
            @if(request()->hasAny(['nama', 'tanggal_mulai', 'tanggal_akhir', 'status']))
                <a href="/admin/absensi" class="abs-reset"><i class="fas fa-rotate-left me-1"></i>Hapus semua filter</a>
            @endif
        </div>
    </div>

    <div class="card border-0 shadow-sm abs-card-tabel">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle abs-tabel mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Waktu</th> <!-- KOLOM BARU -->
                        <th>Nama Siswa</th>
                        <th>Jadwal</th>
                        <th>Status</th>
                        <th>Kas Dibayar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($absensi as $a)
                    <tr>
                        <td data-label="Tanggal">{{ \Carbon\Carbon::parse($a->tanggal)->format('d M Y') }}</td>
                        
                        <!-- MENAMPILKAN WAKTU DARI CREATED_AT -->
                        <td data-label="Waktu">
                            <span class="text-muted"><i class="far fa-clock"></i> {{ $a->created_at ? $a->created_at->format('H:i:s') : '--:--:--' }}</span>
                        </td>
                        
                        <td data-label="Nama Siswa" class="fw-bold nama">{{ $a->siswa->nama_siswa ?? 'Siswa Terhapus' }}</td>
                        <td data-label="Jadwal">{{ $a->jadwal->hari ?? '-' }} ({{ $a->jadwal->keterangan ?? '-' }})</td>
                        <td data-label="Status">
                            @if($a->status_kehadiran == 'hadir')
                                <span class="badge bg-success"><i class="fas fa-check"></i> Hadir</span>
                            @elseif($a->status_kehadiran == 'izin')
                                <span class="badge bg-warning text-dark">Izin</span>
                            @else
                                <span class="badge bg-info text-dark">Sakit</span>
                            @endif
                        </td>
                        <td data-label="Kas Dibayar" class="kas">Rp {{ number_format($a->nominal_kas, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <!-- COLSPAN DIUBAH MENJADI 6 -->
                        <td colspan="6" class="text-center py-4 abs-kosong">Tidak ada data absensi untuk filter ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection