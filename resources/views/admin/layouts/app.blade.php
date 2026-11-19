<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#0f3d2e">
    <title>Admin - Pagar Nusa Ulul-Albab</title>
    
    <link rel="icon" type="image/png" href="{{ asset('img/logotab.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        :root {
            --hijau-tua: #0f3d2e;
            --hijau-muda: #174f3c;
            --hijau: #1d6b4f;
            --hijau-pucat: #e8f1ec;
            --emas: #c9a227;
            --emas-tua: #a8861a;
            --tinta: #16241d;
            --abu: #5d6b64;
            --garis: #dbe5df;
            --bg-body: #f4f7f5;
            --radius: 14px;

            /* Samakan warna bawaan Bootstrap dengan tema Pagar Nusa */
            --bs-primary: #1d6b4f;
            --bs-primary-rgb: 29, 107, 79;
            --bs-link-color: #1d6b4f;
            --bs-link-hover-color: #0f3d2e;
            --bs-body-font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            --bs-body-color: #16241d;
        }

        body {
            background-color: var(--bg-body);
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            color: var(--tinta);
            overflow-x: hidden;
            /* Ruang untuk bottom nav di HP */
            padding-bottom: 0; 
        }
        @media (max-width: 991.98px) {
            body { padding-bottom: 75px; } 
        }

        a:focus-visible, button:focus-visible { outline: 3px solid var(--emas); outline-offset: 2px; }
        .row > * { min-width: 0; }

        /* ---------- SIDEBAR (DESKTOP) ---------- */
        .sidebar {
            background-color: var(--hijau-tua);
            color: white;
            position: sticky; top: 0; align-self: flex-start;
            height: 100vh; overflow-y: auto;
            padding: 0 0 24px;
            border-right: 3px solid var(--emas);
        }
        .brand-admin { display: flex; align-items: center; gap: 12px; padding: 22px 20px 20px; text-decoration: none; }
        .brand-admin img { width: 40px; height: 40px; border-radius: 50%; background: #fff; padding: 3px; object-fit: contain; flex-shrink: 0; }
        .brand-admin .nama { font-family: 'Fraunces', serif; font-weight: 700; font-size: 1.1rem; color: var(--emas); line-height: 1.1; display: block; }
        .brand-admin .ranting { font-size: .72rem; color: rgba(255,255,255,.65); }

        .menu-label { font-size: .78rem; font-weight: 600; color: rgba(255,255,255,.5); padding: 18px 20px 6px; }

        .sidebar .nav-link {
            color: rgba(255,255,255,.82);
            padding: 11px 20px;
            font-size: .94rem; font-weight: 500;
            border-left: 4px solid transparent;
            border-radius: 0;
            transition: background .15s, color .15s;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: var(--hijau-muda);
            color: var(--emas) !important;
            border-left: 4px solid var(--emas);
        }
        .sidebar .nav-link i { width: 25px; text-align: center; margin-right: 10px; }
        .logout-btn { color: #ff9b94 !important; }
        .logout-btn:hover { background-color: rgba(179,50,43,.2) !important; border-left-color: #ff9b94 !important; color: #ffb9b4 !important; }

        /* ---------- BAR ATAS ---------- */
        .top-navbar {
            background-color: white;
            border-bottom: 1px solid var(--garis);
            padding: 10px 20px;
            min-height: 64px;
            position: sticky; top: 0; z-index: 1020;
        }
        .top-navbar .judul-bar { font-family: 'Fraunces', serif; font-weight: 700; color: var(--hijau-tua); font-size: 1.05rem; }
        
        .pengguna { display: flex; align-items: center; gap: 10px; text-decoration: none; color: var(--tinta); padding: 4px 6px; border-radius: 12px; }
        .pengguna:hover { background: var(--bg-body); color: var(--tinta); }
        .pengguna .avatar { width: 38px; height: 38px; border-radius: 50%; background: var(--hijau); color: #fff; display: grid; place-items: center; font-weight: 700; flex-shrink: 0; }
        .pengguna .teks { line-height: 1.2; text-align: left; max-width: 180px; }
        .pengguna .teks b { display: block; font-size: .92rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .pengguna .teks small { color: var(--abu); font-size: .76rem; }
        .dropdown-menu { border: 1px solid var(--garis); border-radius: 12px; box-shadow: 0 12px 30px -10px rgba(15,61,46,.25); padding: 6px; }
        .dropdown-item { border-radius: 8px; padding: 9px 12px; font-weight: 500; }

        /* ---------- KONTEN ---------- */
        .main-content { padding: 30px; }

        /* Poles komponen Bootstrap */
        .main-content .card { border: 1px solid var(--garis); border-radius: var(--radius); box-shadow: none; }
        .main-content .card-header { background: #fff; border-bottom: 1px solid var(--garis); font-weight: 600; }
        .main-content h1, .main-content h2, .main-content h3, .main-content h4 { font-family: 'Fraunces', serif; color: var(--hijau-tua); letter-spacing: -0.01em; }
        .main-content .table > thead th { font-size: .82rem; font-weight: 600; color: var(--abu); background: var(--hijau-pucat); border-bottom: 0; white-space: nowrap; }
        .main-content .table > :not(caption) > * > * { padding: .8rem .9rem; }
        .main-content .btn { border-radius: 10px; font-weight: 600; }
        .main-content .btn-primary { --bs-btn-bg: #1d6b4f; --bs-btn-border-color: #1d6b4f; --bs-btn-hover-bg: #0f3d2e; --bs-btn-hover-border-color: #0f3d2e; --bs-btn-active-bg: #0f3d2e; --bs-btn-active-border-color: #0f3d2e; --bs-btn-disabled-bg: #1d6b4f; --bs-btn-disabled-border-color: #1d6b4f; }
        .main-content .btn-outline-primary { --bs-btn-color: #1d6b4f; --bs-btn-border-color: #1d6b4f; --bs-btn-hover-bg: #1d6b4f; --bs-btn-hover-border-color: #1d6b4f; --bs-btn-active-bg: #1d6b4f; }
        .main-content .form-control, .main-content .form-select { border-radius: 10px; border: 1.5px solid var(--garis); padding: .6rem .8rem; }
        .main-content .form-control:focus, .main-content .form-select:focus { border-color: var(--hijau); box-shadow: 0 0 0 4px rgba(29,107,79,.15); }
        .main-content .form-label { font-weight: 600; color: var(--hijau-tua); }
        .main-content .badge { font-weight: 600; }
        .main-content .alert { border: 0; border-radius: 12px; }
        .main-content .page-link { color: var(--hijau); }
        .main-content .active > .page-link { background: var(--hijau); border-color: var(--hijau); color: #fff; }

        /* ---------- OFFCANVAS (MENU APP STYLE) ---------- */
        .offcanvas { width: 300px; border-right: 3px solid var(--emas); }
        .offcanvas-header { padding: 20px; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .offcanvas-title { font-family: 'Fraunces', serif; font-weight: 700; color: var(--emas) !important; font-size: 1.2rem; }
        
        /* Profil di dalam Offcanvas */
        .offcanvas-profil { display: flex; align-items: center; gap: 15px; padding: 20px; background: rgba(0,0,0,0.2); margin: 15px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.1); }
        .offcanvas-profil .avatar { width: 50px; height: 50px; border-radius: 50%; background: var(--emas); color: var(--hijau-tua); display: grid; place-items: center; font-weight: 700; font-size: 1.2rem; }
        .offcanvas-profil .nama { color: white; font-weight: 600; font-size: 1rem; line-height: 1.2; display: block; }
        .offcanvas-profil .peran { color: var(--emas); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; }

        .offcanvas .nav-link {
            color: rgba(255,255,255,.85);
            padding: 14px 20px;
            font-size: .95rem; font-weight: 500;
            border-left: 4px solid transparent;
            display: flex; align-items: center;
        }
        .offcanvas .nav-link:hover, .offcanvas .nav-link.active {
            background-color: var(--hijau-muda);
            color: var(--emas) !important;
            border-left: 4px solid var(--emas);
        }
        .offcanvas .nav-link i { width: 30px; text-align: center; margin-right: 12px; font-size: 1.1rem; }

        /* ---------- BOTTOM NAVIGATION (HP) ---------- */
        .bottom-nav {
            position: fixed;
            bottom: 0; left: 0; right: 0;
            background: white;
            border-top: 1px solid var(--garis);
            box-shadow: 0 -4px 15px rgba(0,0,0,0.05);
            display: none; /* Disembunyikan di desktop */
            justify-content: space-around;
            align-items: center;
            padding: 8px 5px calc(8px + env(safe-area-inset-bottom));
            z-index: 1030;
        }
        .bottom-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: var(--abu);
            text-decoration: none;
            font-size: 0.7rem;
            font-weight: 600;
            flex: 1;
            padding: 4px 0;
            transition: color 0.2s;
        }
        .bottom-nav-item i {
            font-size: 1.3rem;
            margin-bottom: 3px;
            transition: transform 0.2s;
        }
        .bottom-nav-item.active {
            color: var(--hijau-tua);
        }
        .bottom-nav-item.active i {
            color: var(--hijau-tua);
            transform: scale(1.1);
        }
        .bottom-nav-item:active {
            background-color: var(--bg-body);
            border-radius: 10px;
        }

        @media (max-width: 991.98px) {
            .main-content { padding: 18px 14px 40px; }
            .top-navbar { padding: 8px 14px; }
            .bottom-nav { display: flex; } /* Tampilkan bottom nav di HP */
            .judul-bar { font-size: 0.95rem; } /* Kecilkan teks judul */
        }
        @media (max-width: 575.98px) {
            .pengguna .teks { display: none; }
        }
        @media (prefers-reduced-motion: reduce) { * { transition: none !important; } }
    </style>
</head>
<body>

    <div class="container-fluid">
        <div class="row">

            <!-- SIDEBAR DESKTOP -->
            <div class="col-lg-2 d-none d-lg-block sidebar p-0">
                <a class="brand-admin" href="/admin/dashboard">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo"
                         onerror="this.onerror=null;this.src='data:image/svg+xml;utf8,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 40 40%27%3E%3Ccircle cx=%2720%27 cy=%2720%27 r=%2720%27 fill=%27%231d6b4f%27/%3E%3Ctext x=%2720%27 y=%2726%27 font-size=%2718%27 text-anchor=%27middle%27 fill=%27white%27 font-family=%27serif%27 font-weight=%27bold%27%3EPN%3C/text%3E%3C/svg%3E';">
                    <span>
                        <span class="nama">PAGAR NUSA</span>
                        <span class="ranting">Ulul-Albab</span>
                    </span>
                </a>
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link {{ request()->is('admin/dashboard*') ? 'active' : '' }}" href="/admin/dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('admin/keuangan*') ? 'active' : '' }}" href="/admin/keuangan"><i class="fas fa-wallet"></i> Kelola Keuangan</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('admin/siswa*') ? 'active' : '' }}" href="/admin/siswa"><i class="fas fa-user-graduate"></i> Data Siswa</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('admin/absensi*') ? 'active' : '' }}" href="/admin/absensi"><i class="fas fa-clipboard-list"></i> Riwayat Absensi</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('admin/pelatih*') ? 'active' : '' }}" href="/admin/pelatih"><i class="fas fa-user-tie"></i> Data Pelatih</a></li>

                    @if(Auth::user()->peran == 'super_admin')
                    <li class="menu-label">Khusus super admin</li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('admin/kegiatan*') ? 'active' : '' }}" href="/admin/kegiatan"><i class="fas fa-calendar-alt"></i> Kelola Kegiatan</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('admin/galeri*') ? 'active' : '' }}" href="/admin/galeri"><i class="fas fa-images"></i> Kelola Galeri</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('admin/log-aktivitas*') ? 'active' : '' }}" href="/admin/log-aktivitas"><i class="fas fa-history"></i> Log Aktivitas</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('admin/pengaturan*') ? 'active' : '' }}" href="/admin/pengaturan"><i class="fas fa-cogs"></i> Pengaturan</a></li>
                    @endif

                    <li class="nav-item mt-4">
                        <form action="/admin/logout" method="POST">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link logout-btn w-100 text-start" style="text-decoration: none;">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>

            <!-- KONTEN UTAMA -->
            <div class="col-lg-10 p-0">
                <!-- TOP NAVBAR -->
                <nav class="top-navbar d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-3">
                        <span class="judul-bar">Sistem Informasi Pagar Nusa</span>
                    </div>

                    <div class="dropdown">
                        <a href="#" class="pengguna" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="avatar">{{ strtoupper(mb_substr(Auth::user()->nama_lengkap, 0, 1)) }}</span>
                            <span class="teks">
                                <b>{{ Auth::user()->nama_lengkap }}</b>
                                <small>{{ Auth::user()->peran }}</small>
                            </span>
                            <i class="fas fa-chevron-down small text-muted"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li class="px-3 py-2 d-sm-none">
                                <b class="d-block">{{ Auth::user()->nama_lengkap }}</b>
                                <small class="text-muted">({{ Auth::user()->peran }})</small>
                            </li>
                            <li>
                                <form action="/admin/logout" method="POST">
                                    @csrf
                                    <button class="dropdown-item text-danger" type="submit"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </nav>

                <main class="main-content">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- BOTTOM NAVIGATION BAR (KHUSUS SMARTPHONE)      -->
    <!-- ============================================== -->
    <div class="bottom-nav d-lg-none">
        <a href="/admin/dashboard" class="bottom-nav-item {{ request()->is('admin/dashboard*') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
        <a href="/admin/keuangan" class="bottom-nav-item {{ request()->is('admin/keuangan*') ? 'active' : '' }}">
            <i class="fas fa-wallet"></i>
            <span>Keuangan</span>
        </a>
        <a href="/admin/siswa" class="bottom-nav-item {{ request()->is('admin/siswa*') ? 'active' : '' }}">
            <i class="fas fa-user-graduate"></i>
            <span>Siswa</span>
        </a>
        <a href="/admin/absensi" class="bottom-nav-item {{ request()->is('admin/absensi*') ? 'active' : '' }}">
            <i class="fas fa-clipboard-list"></i>
            <span>Absensi</span>
        </a>
        <!-- Tombol Buka Menu Lengkap -->
        <a href="#" class="bottom-nav-item" data-bs-toggle="offcanvas" data-bs-target="#sidebarMobile">
            <i class="fas fa-bars"></i>
            <span>Menu</span>
        </a>
    </div>

    <!-- ============================================== -->
    <!-- OFFCANVAS MENU LENGKAP (APP STYLE)             -->
    <!-- ============================================== -->
    <div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="sidebarMobile" aria-labelledby="judulMenuMobile" style="background-color: var(--hijau-tua) !important;">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title text-warning" id="judulMenuMobile">PAGAR NUSA</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Tutup"></button>
        </div>
        
        <div class="offcanvas-body p-0 d-flex flex-column">
            <!-- Profil Pengguna di Menu -->
            <div class="offcanvas-profil">
                <div class="avatar">{{ strtoupper(mb_substr(Auth::user()->nama_lengkap, 0, 1)) }}</div>
                <div>
                    <span class="nama">{{ Auth::user()->nama_lengkap }}</span>
                    <span class="peran">{{ Auth::user()->peran }}</span>
                </div>
            </div>

            <!-- List Menu -->
            <ul class="nav flex-column flex-grow-1">
                <li class="nav-item"><a class="nav-link text-white {{ request()->is('admin/dashboard*') ? 'active' : '' }}" href="/admin/dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li class="nav-item"><a class="nav-link text-white {{ request()->is('admin/keuangan*') ? 'active' : '' }}" href="/admin/keuangan"><i class="fas fa-wallet"></i> Kelola Keuangan</a></li>
                <li class="nav-item"><a class="nav-link text-white {{ request()->is('admin/siswa*') ? 'active' : '' }}" href="/admin/siswa"><i class="fas fa-user-graduate"></i> Data Siswa</a></li>
                <li class="nav-item"><a class="nav-link text-white {{ request()->is('admin/absensi*') ? 'active' : '' }}" href="/admin/absensi"><i class="fas fa-clipboard-list"></i> Riwayat Absensi</a></li>
                <li class="nav-item"><a class="nav-link text-white {{ request()->is('admin/pelatih*') ? 'active' : '' }}" href="/admin/pelatih"><i class="fas fa-user-tie"></i> Data Pelatih</a></li>

                @if(Auth::user()->peran == 'super_admin')
                <li class="menu-label">Khusus super admin</li>
                <li class="nav-item"><a class="nav-link text-white {{ request()->is('admin/kegiatan*') ? 'active' : '' }}" href="/admin/kegiatan"><i class="fas fa-calendar-alt"></i> Kelola Kegiatan</a></li>
                <li class="nav-item"><a class="nav-link text-white {{ request()->is('admin/galeri*') ? 'active' : '' }}" href="/admin/galeri"><i class="fas fa-images"></i> Kelola Galeri</a></li>
                <li class="nav-item"><a class="nav-link text-white {{ request()->is('admin/log-aktivitas*') ? 'active' : '' }}" href="/admin/log-aktivitas"><i class="fas fa-history"></i> Log Aktivitas</a></li>
                <li class="nav-item"><a class="nav-link text-white {{ request()->is('admin/pengaturan*') ? 'active' : '' }}" href="/admin/pengaturan"><i class="fas fa-cogs"></i> Pengaturan</a></li>
                @endif
            </ul>

            <!-- Tombol Logout di Bawah -->
            <div class="p-3 mt-auto border-top border-secondary border-opacity-25">
                <form action="/admin/logout" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger w-100 py-2" style="border-radius: 10px; font-weight: 600;">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>