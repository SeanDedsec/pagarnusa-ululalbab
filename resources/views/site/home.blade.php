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
                <img src="https://via.placeholder.com/40" alt="Logo"> 
                PAGAR NUSA <br><small style="font-size: 10px; font-weight: 300;">Ranting Mancar Ulul-Albab</small>
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
                    <p class="text-uppercase" style="letter-spacing: 2px; color: var(--emas);">Pagar Nusa Ranting Mancar Ulul-Albab</p>
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
            <p class="text-center text-muted">(Nanti data ini akan diambil dari database melalui API Laravel)</p>
        </div>
    </section>

    <section id="jadwal">
        <div class="container">
            <h2 class="section-title">Jadwal Latihan</h2>
            <p class="text-center text-muted">(Nanti data ini akan diambil dari database melalui API Laravel)</p>
        </div>
    </section>

    <section id="kegiatan" class="bg-light-custom">
        <div class="container">
            <h2 class="section-title">Kegiatan & Event</h2>
            <p class="text-center text-muted">(Nanti data ini akan diambil dari database melalui API Laravel)</p>
        </div>
    </section>

    <section id="transparansi">
        <div class="container">
            <h2 class="section-title">Transparansi Keuangan</h2>
            <p class="text-center text-muted">(Nanti data ini akan diambil dari database melalui API Laravel)</p>
        </div>
    </section>

    <footer class="py-4 text-center text-white" style="background-color: var(--hijau-tua);">
        <div class="container">
            <p class="mb-0">&copy; 2026 Pagar Nusa Ranting Mancar Ulul-Albab. All rights reserved.</p>
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