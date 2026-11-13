<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Pagar Nusa Ulul-Albab</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --hijau-tua: #0b3d2e;
            --hijau-muda: #145a43;
            --emas: #d4af37;
            --bg-body: #f4f7f6;
        }
        body {
            background-color: var(--bg-body);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        /* SIDEBAR STYLE */
        .sidebar {
            background-color: var(--hijau-tua);
            min-height: 100vh;
            color: white;
            padding-top: 20px;
            transition: 0.3s;
        }
        .sidebar h4 {
            text-align: center;
            font-weight: 700;
            color: var(--emas);
            margin-bottom: 30px;
            font-size: 1.2rem;
        }
        .sidebar .nav-link {
            color: #d1d5db;
            padding: 12px 20px;
            font-size: 0.95rem;
            border-left: 4px solid transparent;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: var(--hijau-muda);
            color: var(--emas);
            border-left: 4px solid var(--emas);
        }
        .sidebar .nav-link i {
            width: 25px;
            text-align: center;
            margin-right: 10px;
        }

        .top-navbar {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            padding: 15px 20px;
        }

        .main-content {
            padding: 30px;
        }

        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }
            .main-content {
                padding: 15px;
            }
        }
    </style>
</head>
<body>

    <div class="container-fluid">
        <div class="row">

            <!-- SIDEBAR DESKTOP -->
            <div class="col-md-2 d-none d-md-block sidebar p-0">
                <h4 class="mt-3">PAGAR NUSA</h4>
                <ul class="nav flex-column mt-4">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}" href="/admin/dashboard">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/keuangan') ? 'active' : '' }}" href="/admin/keuangan"><i class="fas fa-wallet"></i> Kelola Keuangan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/siswa') ? 'active' : '' }}" href="/admin/siswa"><i class="fas fa-user-graduate"></i> Data Siswa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/absensi') ? 'active' : '' }}" href="/admin/absensi"><i class="fas fa-clipboard-list"></i> Riwayat Absensi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/pelatih') ? 'active' : '' }}" href="/admin/pelatih"><i class="fas fa-user-tie"></i> Data Pelatih</a>
                    </li>

                    <!-- MENU KHUSUS SUPER ADMIN -->
                    @if(Auth::user()->peran == 'super_admin')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/kegiatan') ? 'active' : '' }}" href="/admin/kegiatan"><i class="fas fa-calendar-alt"></i> Kelola Kegiatan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/galeri') ? 'active' : '' }}" href="/admin/galeri"><i class="fas fa-images"></i> Kelola Galeri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/log-aktivitas') ? 'active' : '' }}" href="/admin/log-aktivitas"><i class="fas fa-history"></i> Log Aktivitas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/pengaturan') ? 'active' : '' }}" href="/admin/pengaturan"><i class="fas fa-cogs"></i> Pengaturan</a>
                    </li>
                    @endif
                    
                    <li class="nav-item mt-5">
                        <form action="/admin/logout" method="POST">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link text-danger w-100 text-start" style="text-decoration: none;">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>

            <!-- KONTEN UTAMA -->
            <div class="col-md-10 p-0">
                <nav class="top-navbar d-flex justify-content-between align-items-center">
                    <button class="btn btn-outline-dark d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMobile">
                        <i class="fas fa-bars"></i>
                    </button>
                    <span class="fw-bold text-dark d-none d-md-inline">Sistem Informasi Pagar Nusa</span>
                    
                    <div class="dropdown">
                        <a href="#" class="text-decoration-none text-dark dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle fa-lg me-1"></i> {{ Auth::user()->nama_lengkap }} ({{ Auth::user()->peran }})
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form action="/admin/logout" method="POST">
                                    @csrf
                                    <button class="dropdown-item text-danger" type="submit">Logout</button>
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

    <!-- SIDEBAR MOBILE (OFFCANVAS) -->
    <div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="sidebarMobile" style="background-color: var(--hijau-tua) !important;">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title text-warning">PAGAR NUSA</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body p-0">
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link text-white" href="/admin/dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="/admin/keuangan"><i class="fas fa-wallet"></i> Kelola Keuangan</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="/admin/siswa"><i class="fas fa-user-graduate"></i> Data Siswa</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="/admin/absensi"><i class="fas fa-clipboard-list"></i> Riwayat Absensi</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="/admin/pelatih"><i class="fas fa-user-tie"></i> Data Pelatih</a></li>
                
                @if(Auth::user()->peran == 'super_admin')
                <li class="nav-item"><a class="nav-link text-white" href="/admin/kegiatan"><i class="fas fa-calendar-alt"></i> Kelola Kegiatan</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="/admin/galeri"><i class="fas fa-images"></i> Kelola Galeri</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="/admin/log-aktivitas"><i class="fas fa-history"></i> Log Aktivitas</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="/admin/pengaturan"><i class="fas fa-cogs"></i> Pengaturan</a></li>
                @endif
            </ul>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>