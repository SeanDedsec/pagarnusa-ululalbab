@extends('admin.layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold" style="color: var(--hijau-tua);">Dashboard</h2>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm" style="border-left: 5px solid var(--hijau-tua) !important;">
                <div class="card-body">
                    <h6 class="text-muted">Total Siswa</h6>
                    <h3 class="fw-bold">0</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm" style="border-left: 5px solid var(--emas) !important;">
                <div class="card-body">
                    <h6 class="text-muted">Kas Bulan Ini</h6>
                    <h3 class="fw-bold">Rp 0</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm" style="border-left: 5px solid #dc3545 !important;">
                <div class="card-body">
                    <h6 class="text-muted">Pendaftar Baru (Pending)</h6>
                    <h3 class="fw-bold">0</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="alert alert-success mt-4">
        Selamat datang, <strong>{{ Auth::user()->nama_lengkap }}</strong>! Anda login sebagai <strong>{{ Auth::user()->peran }}</strong>.
    </div>
@endsection