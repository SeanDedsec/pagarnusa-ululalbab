<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagar Nusa Ranting Mancar Ulul-Albab</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --hijau-tua: #0b3d2e;
            --hijau-muda: #145a43;
            --emas: #d4af37;
            --putih: #ffffff;
        }

        body {
            font-family: 'Poppins', sans-serif;
            scroll-behavior: smooth;
        }

        .navbar {
            background-color: rgba(11, 61, 46, 0.95);
            transition: background-color 0.3s;
            padding: 15px 0;
        }
        .navbar-brand {
            color: var(--putih) !important;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .navbar-brand img {
            width: 40px;
            height: 40px;
            background-color: white;
            border-radius: 50%;
            padding: 2px;
        }
        .nav-link {
            color: var(--putih) !important;
            font-weight: 400;
            margin: 0 10px;
            transition: color 0.3s;
        }
        .nav-link:hover {
            color: var(--emas) !important;
        }

        .btn-emas {
            background-color: var(--emas);
            color: #000;
            font-weight: 600;
            border-radius: 30px;
            padding: 10px 25px;
            transition: 0.3s;
        }
        .btn-emas:hover {
            background-color: #b8962e;
            color: #000;
        }

        #beranda {
            background: linear-gradient(rgba(11, 61, 46, 0.85), rgba(11, 61, 46, 0.85)), 
                        url('https://images.unsplash.com/photo-1555597673-b21d5c935865?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover;
            height: 100vh;
            display: flex;
            align-items: center;
            color: var(--putih);
        }
        #beranda h1 {
            font-size: 3.5rem;
            font-weight: 700;
            line-height: 1.2;
        }
        #beranda h1 span {
            color: var(--emas);
        }

        section {
            padding: 80px 0;
            min-height: 400px;
        }
        .bg-light-custom {
            background-color: #f8f9fa;
        }
        .section-title {
            color: var(--hijau-tua);
            font-weight: 700;
            margin-bottom: 20px;
            text-align: center;
        }
        .section-title::after {
            content: '';
            display: block;
            width: 60px;
            height: 3px;
            background-color: var(--emas);
            margin: 10px auto 0;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="https://via.placeholder.com/40" alt="Logo">PAGAR NUSA <br><small style="font-size: 10px; font-weight: 300;">{{ $identitas['nama_organisasi'] }}</small>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#beranda">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#profil">Profil</a></li>
                    <li class="nav-item"><a class="nav-link" href="#pelatih">Pelatih</a></li>
                    <li class="nav-item"><a class="nav-link" href="#jadwal">Jadwal</a></li>
                    <li class="nav-item"><a class="nav-link" href="#kegiatan">Kegiatan</a></li>
                    <!-- MENU GALERI DIHAPUS DARI SINI -->
                    <li class="nav-item"><a class="nav-link" href="#transparansi">Transparansi</a></li>
                    <li class="nav-item ms-3">
                        <a class="btn btn-emas btn-sm" href="/pendaftaran">Pendaftaran</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section id="beranda">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <p class="text-uppercase" style="letter-spacing: 2px; color: var(--emas);">{{ $identitas['nama_organisasi'] }}</p>
                    <h1>Administrasi Tertata,<br><span>Organisasi Lebih Terbuka</span></h1>
                    <p class="lead mt-4">Bersama Pagar Nusa, kita wujudkan generasi yang berakhlak mulia, berilmu, dan berprestasi melalui pencak silat.</p>
                    <div class="mt-4">
                        <a href="#profil" class="btn btn-emas me-2">Lihat Profil</a>
                        <a href="/pendaftaran" class="btn btn-outline-light" style="border-radius: 30px; padding: 10px 25px;">Informasi Pendaftaran</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="profil">
        <div class="container">
            <h2 class="section-title">Profil Organisasi</h2>
            <div class="row text-center mt-5">
                <div class="col-md-4">
                    <i class="fa-solid fa-shield-halved fa-3x mb-3" style="color: var(--hijau-tua);"></i>
                    <h4>Sejarah</h4>
                    <p>Mengenal lebih dekat Pagar Nusa Ranting Mancar Ulul-Albab.</p>
                </div>
                <div class="col-md-4">
                    <i class="fa-solid fa-users fa-3x mb-3" style="color: var(--hijau-tua);"></i>
                    <h4>Visi & Misi</h4>
                    <p>Mewujudkan generasi pencak silat yang berakhlak dan berprestasi.</p>
                </div>
                <div class="col-md-4">
                    <i class="fa-solid fa-handshake fa-3x mb-3" style="color: var(--hijau-tua);"></i>
                    <h4>Struktur</h4>
                    <p>Struktur kepengurusan Ranting Mancar Ulul-Albab.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="pelatih" class="bg-light-custom">
        <div class="container">
            <h2 class="section-title">Data Pelatih</h2>
            <div class="row mt-5 justify-content-center">
                @forelse($pelatih as $p)
                <div class="col-md-4 mb-4">
                    <div class="card border-0 shadow-sm text-center h-100">
                        <div class="card-body">
                            <i class="fas fa-user-circle fa-4x mb-3" style="color: var(--hijau-tua);"></i>
                            <h5 class="fw-bold">{{ $p->nama_pelatih }}</h5>
                            <p class="text-muted mb-1"><i class="fas fa-phone"></i> {{ $p->no_hp }}</p>
                            <p class="text-muted"><i class="fas fa-map-marker-alt"></i> {{ $p->alamat }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center text-muted">Belum ada data pelatih.</div>
                @endforelse
            </div>
        </div>
    </section>

    <section id="jadwal">
        <div class="container">
            <h2 class="section-title">Jadwal Latihan</h2>
            <div class="row mt-5 justify-content-center">
                @forelse($jadwal as $j)
                <div class="col-md-3 mb-4">
                    <div class="card border-0 shadow-sm text-center h-100" style="border-bottom: 4px solid var(--emas) !important;">
                        <div class="card-body">
                            <h4 class="fw-bold text-success">{{ $j->hari }}</h4>
                            <p class="mb-1">{{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }} WIB</p>
                            <span class="badge bg-secondary">{{ $j->keterangan }}</span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center text-muted">Belum ada jadwal latihan.</div>
                @endforelse
            </div>
        </div>
    </section>


    <section id="kegiatan" class="bg-light-custom">
        <div class="container">
            <h2 class="section-title">Kegiatan & Event Terbaru</h2>
            <div class="row mt-5">
                @forelse($kegiatan as $k)
                <div class="col-md-4 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        
                        @if($k->galeri->isNotEmpty())
                            <img src="{{ asset('storage/' . $k->galeri->first()->file_foto) }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="{{ $k->judul }}">
                        @else
                            <img src="https://via.placeholder.com/400x200?text=No+Image" class="card-img-top" style="height: 200px; object-fit: cover;" alt="No Image">
                        @endif

                        <div class="card-body">
                            <small class="text-muted">{{ \Carbon\Carbon::parse($k->tanggal)->format('d M Y') }}</small>
                            <h5 class="fw-bold mt-2">{{ $k->judul }}</h5>
                            <p class="text-muted"><i class="fas fa-map-marker-alt"></i> {{ $k->lokasi }}</p>
                            <p>{{ Str::limit($k->deskripsi, 100) }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center text-muted">Belum ada kegiatan yang dipublikasikan.</div>
                @endforelse
            </div>
        </div>
    </section>

    <section id="transparansi">
        <div class="container">
            <h2 class="section-title">Transparansi Keuangan</h2>
            <div class="row mt-5 justify-content-center">
                <div class="col-md-4 mb-3">
                    <div class="card border-0 shadow-sm text-center bg-success text-white">
                        <div class="card-body">
                            <h5>Total Pemasukan</h5>
                            <h3 class="fw-bold">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card border-0 shadow-sm text-center bg-danger text-white">
                        <div class="card-body">
                            <h5>Total Pengeluaran</h5>
                            <h3 class="fw-bold">Rp {{ number_format($totalKeluar, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card border-0 shadow-sm text-center bg-primary text-white">
                        <div class="card-body">
                            <h5>Saldo Kas</h5>
                            <h3 class="fw-bold">Rp {{ number_format($saldo, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-3">
                <small class="text-muted">*Data diperbarui secara otomatis dari sistem administrasi.</small>
            </div>
        </div>
    </section>

    <footer class="py-5 text-center text-white" style="background-color: var(--hijau-tua);">
        <div class="container">
            <h5 class="fw-bold">{{ $identitas['nama_organisasi'] }}</h5>
            <p class="mb-1"><i class="fas fa-map-marker-alt"></i> {{ $identitas['alamat'] }}</p>
            <p class="mb-3"><i class="fas fa-phone"></i> {{ $identitas['no_hp'] }}</p>
            <hr class="bg-light" style="width: 50%; margin: 20px auto;">
            <p class="mb-0 text-white-50">&copy; {{ date('Y') }} {{ $identitas['nama_organisasi'] }}. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.backgroundColor = '#0b3d2e';
                navbar.style.boxShadow = '0 2px 10px rgba(0,0,0,0.3)';
            } else {
                navbar.style.backgroundColor = 'rgba(11, 61, 46, 0.95)';
                navbar.style.boxShadow = 'none';
            }
        });
    </script>
</body>
</html>