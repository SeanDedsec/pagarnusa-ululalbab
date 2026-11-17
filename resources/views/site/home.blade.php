<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0f3d2e">
    <title>Pagar Nusa Ranting Mancar Ulul-Albab</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600;9..144,700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        :root {
            --hijau-tua: #0f3d2e;
            --hijau: #1d6b4f;
            --hijau-pucat: #e8f1ec;
            --emas: #c9a227;
            --emas-tua: #a8861a;
            --tinta: #16241d;
            --abu: #5d6b64;
            --garis: #dbe5df;
            --latar: #f6f8f6;
            --putih: #ffffff;
            --radius: 16px;
            --nav-h: 68px;
        }

        html { scroll-behavior: smooth; scroll-padding-top: calc(var(--nav-h) + 8px); }
        body {
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            color: var(--tinta);
            background: var(--putih);
            line-height: 1.65;
            padding-bottom: 76px; /* ruang untuk bar bawah di HP */
        }
        h1, h2, h3, h4, h5 { font-family: 'Fraunces', Georgia, serif; font-weight: 700; line-height: 1.2; letter-spacing: -0.01em; }
        a:focus-visible, button:focus-visible { outline: 3px solid var(--emas); outline-offset: 2px; }

        /* ---------- Navbar ---------- */
        .navbar { background: var(--hijau-tua); min-height: var(--nav-h); padding: 8px 0; transition: box-shadow .25s; }
        .navbar.scrolled { box-shadow: 0 4px 18px rgba(0,0,0,.25); }
        .navbar-brand { display: flex; align-items: center; gap: 12px; color: var(--putih) !important; padding: 0; }
        .navbar-brand img { width: 42px; height: 42px; border-radius: 50%; background: #fff; padding: 3px; object-fit: contain; flex-shrink: 0; }
        .brand-text { display: flex; flex-direction: column; line-height: 1.15; }
        .brand-text strong { font-family: 'Fraunces', serif; font-size: 1.05rem; }
        .brand-text small { font-size: .72rem; font-weight: 400; color: rgba(255,255,255,.75); max-width: 190px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .nav-link { color: rgba(255,255,255,.88) !important; font-weight: 500; padding: 10px 14px !important; }
        .nav-link:hover { color: var(--emas) !important; }
        .navbar-toggler { border: 0; padding: 8px; }
        .navbar-toggler:focus { box-shadow: 0 0 0 3px var(--emas); }
        .navbar-toggler-icon { filter: invert(1); }
        @media (max-width: 991.98px) {
            .navbar-collapse { padding: 8px 0 16px; border-top: 1px solid rgba(255,255,255,.12); margin-top: 8px; }
            .nav-link { font-size: 1.05rem; border-radius: 10px; }
            .nav-link:active { background: rgba(255,255,255,.08); }
        }

        /* ---------- Tombol ---------- */
        .btn-emas {
            background: var(--emas); color: #1c1700; font-weight: 700;
            border: 0; border-radius: 999px; padding: 12px 26px;
            transition: background .2s, transform .15s;
        }
        .btn-emas:hover { background: var(--emas-tua); color: #fff; }
        .btn-emas:active { transform: scale(.97); }
        .btn-garis {
            border: 2px solid rgba(255,255,255,.55); color: var(--putih); font-weight: 600;
            border-radius: 999px; padding: 10px 24px; background: transparent;
        }
        .btn-garis:hover { background: var(--putih); color: var(--hijau-tua); border-color: var(--putih); }

        /* ---------- Hero ---------- */
        #beranda {
            position: relative;
            background:
                radial-gradient(circle at 85% 10%, rgba(201,162,39,.22), transparent 38%),
                repeating-linear-gradient(135deg, rgba(255,255,255,.035) 0 2px, transparent 2px 22px),
                var(--hijau-tua);
            color: var(--putih);
            padding: calc(var(--nav-h) + 48px) 0 110px;
        }
        #beranda::after { /* garis emas tipis di tepi bawah */
            content: ''; position: absolute; left: 0; right: 0; bottom: 0; height: 4px; background: var(--emas);
        }
        .hero-org { color: var(--emas); font-weight: 600; font-size: .95rem; margin-bottom: 14px; }
        #beranda h1 { font-size: clamp(2rem, 6.2vw, 3.6rem); max-width: 18ch; margin-bottom: 18px; }
        .hero-lead { font-size: 1.05rem; color: rgba(255,255,255,.86); max-width: 52ch; }
        .hero-cta { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 28px; }
        @media (max-width: 575.98px) {
            .hero-cta .btn { width: 100%; text-align: center; }
        }

        /* Panel "mulai dari mana" - menimpa tepi hero */
        .mulai { margin-top: -64px; position: relative; z-index: 2; }
        .mulai-box {
            background: var(--putih); border-radius: 20px; padding: 8px;
            box-shadow: 0 18px 40px -12px rgba(15,61,46,.28);
            display: grid; grid-template-columns: 1fr; gap: 4px;
        }
        .mulai-item {
            display: flex; align-items: center; gap: 14px; padding: 16px;
            border-radius: 14px; color: var(--tinta); text-decoration: none;
            transition: background .2s;
        }
        .mulai-item:hover { background: var(--hijau-pucat); color: var(--tinta); }
        .mulai-item i.ikon {
            width: 46px; height: 46px; border-radius: 12px; background: var(--hijau-pucat); color: var(--hijau);
            display: grid; place-items: center; font-size: 1.15rem; flex-shrink: 0;
        }
        .mulai-item b { display: block; line-height: 1.3; }
        .mulai-item span { font-size: .88rem; color: var(--abu); line-height: 1.4; display: block; }
        .mulai-item .panah { margin-left: auto; color: var(--abu); }
        @media (min-width: 768px) {
            .mulai-box { grid-template-columns: repeat(3, 1fr); }
        }

        /* ---------- Section umum ---------- */
        section.blok { padding: 72px 0; }
        section.blok.abu { background: var(--latar); }
        .judul { margin-bottom: 32px; max-width: 640px; }
        .judul h2 { font-size: clamp(1.6rem, 4.5vw, 2.2rem); color: var(--hijau-tua); margin-bottom: 8px; }
        .judul p { color: var(--abu); margin: 0; }
        .judul::after { content: ''; display: block; width: 48px; height: 4px; border-radius: 4px; background: var(--emas); margin-top: 16px; }
        .kosong { padding: 28px; text-align: center; color: var(--abu); background: var(--putih); border: 1px dashed var(--garis); border-radius: var(--radius); }

        /* ---------- Profil ---------- */
        .profil-item { display: flex; flex-direction: column; align-items: center; text-align: center; padding: 24px; background: var(--putih); border-radius: var(--radius); border: 1px solid var(--garis); box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); }
        .profil-item i { color: var(--hijau); font-size: 2.5rem; margin-bottom: 16px; }
        .profil-item h4 { font-size: 1.25rem; margin-bottom: 8px; }
        .profil-item p { margin: 0; color: var(--abu); }
        .profil-wrap { max-width: 600px; margin: 0 auto; }

        /* ---------- Pelatih ---------- */
        .pelatih-card {
            background: var(--putih); border: 1px solid var(--garis); border-radius: var(--radius);
            padding: 18px; display: flex; gap: 16px; align-items: center; height: 100%;
        }
        .avatar {
            width: 60px; height: 60px; border-radius: 50%; flex-shrink: 0;
            background: var(--hijau); color: var(--putih);
            display: grid; place-items: center;
            font-family: 'Fraunces', serif; font-size: 1.4rem; font-weight: 700;
        }
        .pelatih-card h5 { font-size: 1.05rem; margin-bottom: 4px; }
        .pelatih-card p { margin: 0; font-size: .9rem; color: var(--abu); line-height: 1.5; }
        .pelatih-card p i { width: 16px; color: var(--hijau); }

        /* ---------- Jadwal (daftar baris) ---------- */
        .jadwal-list { background: var(--putih); border: 1px solid var(--garis); border-radius: var(--radius); overflow: hidden; }
        .jadwal-row { display: flex; align-items: center; gap: 16px; padding: 18px 20px; border-bottom: 1px solid var(--garis); }
        .jadwal-row:last-child { border-bottom: 0; }
        .jadwal-hari { font-family: 'Fraunces', serif; font-weight: 700; font-size: 1.2rem; color: var(--hijau-tua); min-width: 96px; }
        .jadwal-jam { font-weight: 600; }
        .jadwal-ket { margin-left: auto; font-size: .82rem; background: var(--hijau-pucat); color: var(--hijau-tua); padding: 4px 12px; border-radius: 999px; font-weight: 600; text-align: right; }
        @media (max-width: 575.98px) {
            .jadwal-row { flex-wrap: wrap; gap: 4px 12px; }
            .jadwal-hari { min-width: 0; flex: 1 0 40%; }
            .jadwal-ket { margin-left: 0; text-align: left; }
            .jadwal-row .jadwal-jam { flex: 1 0 100%; order: 3; color: var(--abu); font-weight: 500; }
        }

        /* ---------- Kegiatan ---------- */
        .kegiatan-card { background: var(--putih); border-radius: var(--radius); overflow: hidden; height: 100%; border: 1px solid var(--garis); display: flex; flex-direction: column; }
        .kegiatan-card img { width: 100%; height: 210px; object-fit: cover; background: var(--hijau-pucat); }
        .kegiatan-body { padding: 20px; }
        .kegiatan-tgl { font-size: .85rem; font-weight: 600; color: var(--emas-tua); }
        .kegiatan-card h5 { font-size: 1.15rem; margin: 6px 0 8px; }
        .kegiatan-lokasi { font-size: .88rem; color: var(--abu); margin-bottom: 10px; }
        .kegiatan-lokasi i { color: var(--hijau); margin-right: 4px; }
        .kegiatan-card p.desk { margin: 0; color: var(--tinta); font-size: .95rem; }

        /* ---------- Footer ---------- */
        footer { background: var(--hijau-tua); color: rgba(255,255,255,.85); padding: 48px 0 28px; }
        footer h5 { color: var(--putih); font-size: 1.25rem; }
        footer a { color: var(--emas); text-decoration: none; }
        .peta { border-radius: var(--radius); overflow: hidden; background: rgba(255,255,255,.08); aspect-ratio: 4 / 3; }
        .peta iframe { width: 100%; height: 100%; border: 0; display: block; }
        .btn-rute { display: inline-block; margin-top: 12px; font-weight: 600; font-size: .92rem; }
        @media (min-width: 992px) { .peta { aspect-ratio: 16 / 10; } }
        footer .salin { border-top: 1px solid rgba(255,255,255,.14); margin-top: 28px; padding-top: 20px; font-size: .85rem; color: rgba(255,255,255,.6); }

        /* ---------- Bar aksi bawah (HP) ---------- */
        .bar-bawah {
            position: fixed; left: 0; right: 0; bottom: 0; z-index: 1030;
            background: var(--putih); border-top: 1px solid var(--garis);
            padding: 10px 14px calc(10px + env(safe-area-inset-bottom, 0px));
            display: flex; gap: 10px; box-shadow: 0 -6px 20px rgba(0,0,0,.08);
        }
        .bar-bawah a { flex: 1; text-align: center; padding: 12px; border-radius: 999px; font-weight: 700; text-decoration: none; font-size: .95rem; }
        .bar-bawah .daftar { background: var(--hijau-tua); color: var(--putih); }
        .bar-bawah .hubungi { background: var(--hijau-pucat); color: var(--hijau-tua); }
        @media (min-width: 992px) {
            .bar-bawah { display: none; }
            body { padding-bottom: 0; }
            section.blok { padding: 96px 0; }
        }

        @media (prefers-reduced-motion: reduce) {
            html { scroll-behavior: auto; }
            * { transition: none !important; }
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg fixed-top" id="navbar">
        <div class="container">
            <a class="navbar-brand" href="#beranda">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Pagar Nusa"
                     onerror="this.onerror=null;this.src='data:image/svg+xml;utf8,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 40 40%27%3E%3Ccircle cx=%2720%27 cy=%2720%27 r=%2720%27 fill=%27%231d6b4f%27/%3E%3Ctext x=%2720%27 y=%2726%27 font-size=%2718%27 text-anchor=%27middle%27 fill=%27white%27 font-family=%27serif%27 font-weight=%27bold%27%3EPN%3C/text%3E%3C/svg%3E';">
                <span class="brand-text">
                    <strong>Pagar Nusa</strong>
                    <small>{{ $identitas['nama_organisasi'] }}</small>
                </span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Buka menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item"><a class="nav-link" href="#beranda">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#profil">Profil</a></li>
                    <li class="nav-item"><a class="nav-link" href="#pelatih">Pelatih</a></li>
                    <li class="nav-item"><a class="nav-link" href="#jadwal">Jadwal</a></li>
                    <li class="nav-item"><a class="nav-link" href="#kegiatan">Kegiatan</a></li>
                    <!-- Menu Transparansi Dihapus -->
                    <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                        <a class="btn btn-emas btn-sm" href="/pendaftaran">Pendaftaran</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section id="beranda">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <p class="hero-org">{{ $identitas['nama_organisasi'] }}</p>
                    <h1>Anak belajar pencak silat, dibimbing dengan akhlak</h1>
                    <p class="hero-lead">Pagar Nusa membina generasi yang berakhlak mulia, berilmu, dan berprestasi. Lihat jadwal latihan, kenali pelatihnya, dan pantau kegiatan serta keuangan organisasi di sini.</p>
                    <div class="hero-cta">
                        <a href="/pendaftaran" class="btn btn-emas">Daftar jadi anggota</a>
                        <a href="#jadwal" class="btn btn-garis">Lihat jadwal latihan</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="mulai">
        <div class="container">
            <div class="mulai-box">
                <a class="mulai-item" href="/pendaftaran">
                    <i class="fa-solid fa-user-plus ikon"></i>
                    <div><b>Daftarkan anak</b><span>Lihat syarat dan cara mendaftar</span></div>
                    <i class="fa-solid fa-chevron-right panah"></i>
                </a>
                <a class="mulai-item" href="#jadwal">
                    <i class="fa-regular fa-calendar-check ikon"></i>
                    <div><b>Jadwal latihan</b><span>Hari dan jam latihan mingguan</span></div>
                    <i class="fa-solid fa-chevron-right panah"></i>
                </a>
                <!-- Tautan ke WhatsApp -->
                <a class="mulai-item" href="https://wa.me/62881027554000" target="_blank" rel="noopener">
                    <i class="fab fa-whatsapp ikon"></i>
                    <div><b>Hubungi pengurus</b><span>Tanya langsung via WhatsApp</span></div>
                    <i class="fa-solid fa-chevron-right panah"></i>
                </a>
            </div>
        </div>
    </div>

    <section id="profil" class="blok">
        <div class="container">
            <div class="judul">
                <h2>Profil organisasi</h2>
                <p>Kenali Pagar Nusa Ranting Mancar Ulul-Albab.</p>
            </div>
            <div class="profil-wrap">
                <div class="profil-item">
                    <i class="fa-solid fa-shield-halved"></i>
                    <div>
                        <h4>Sejarah</h4>
                        <p>Mengenal lebih dekat Pagar Nusa Ranting Mancar Ulul-Albab.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="pelatih" class="blok abu">
        <div class="container">
            <div class="judul">
                <h2>Pelatih</h2>
                <p>Orang-orang yang membimbing anak Anda saat latihan.</p>
            </div>
            <div class="row g-3">
                @forelse($pelatih as $p)
                <div class="col-md-6 col-lg-4">
                    <div class="pelatih-card">
                        <div class="avatar">{{ strtoupper(mb_substr($p->nama_pelatih, 0, 1)) }}</div>
                        <div>
                            <h5>{{ $p->nama_pelatih }}</h5>
                            <p><i class="fas fa-phone"></i> {{ $p->no_hp }}</p>
                            <p><i class="fas fa-map-marker-alt"></i> {{ $p->alamat }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12"><div class="kosong">Belum ada data pelatih.</div></div>
                @endforelse
            </div>
        </div>
    </section>

    <section id="jadwal" class="blok">
        <div class="container">
            <div class="judul">
                <h2>Jadwal latihan</h2>
                <p>Datang 10 menit lebih awal supaya anak siap memulai.</p>
            </div>
            @if($jadwal->isNotEmpty())
            <div class="jadwal-list">
                @foreach($jadwal as $j)
                <div class="jadwal-row">
                    <div class="jadwal-hari">{{ $j->hari }}</div>
                    <div class="jadwal-jam">{{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }} WIB</div>
                    <span class="jadwal-ket">{{ $j->keterangan }}</span>
                </div>
                @endforeach
            </div>
            @else
            <div class="kosong">Belum ada jadwal latihan.</div>
            @endif
        </div>
    </section>

    <section id="kegiatan" class="blok abu">
        <div class="container">
            <div class="judul">
                <h2>Kegiatan &amp; event terbaru</h2>
                <p>Kabar terbaru dari latihan, pertandingan, dan acara organisasi.</p>
            </div>
            <div class="row g-4">
                @forelse($kegiatan as $k)
                <div class="col-md-6 col-lg-4">
                    <article class="kegiatan-card">
                        @if($k->galeri->isNotEmpty())
                            <img src="{{ asset('storage/' . $k->galeri->first()->file_foto) }}" loading="lazy" alt="{{ $k->judul }}">
                        @else
                            <img src="https://via.placeholder.com/400x200?text=No+Image" loading="lazy" alt="No Image">
                        @endif

                        <div class="kegiatan-body">
                            <div class="kegiatan-tgl">{{ \Carbon\Carbon::parse($k->tanggal)->format('d M Y') }}</div>
                            <h5>{{ $k->judul }}</h5>
                            <p class="kegiatan-lokasi"><i class="fas fa-map-marker-alt"></i>{{ $k->lokasi }}</p>
                            <p class="desk">{{ Str::limit($k->deskripsi, 100) }}</p>
                        </div>
                    </article>
                </div>
                @empty
                <div class="col-12"><div class="kosong">Belum ada kegiatan yang dipublikasikan.</div></div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- SECTION TRANSPARANSI DIHAPUS DARI SINI -->

    <footer>
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col-lg-5">
                    <h5>{{ $identitas['nama_organisasi'] }}</h5>
                    <p class="mb-1"><i class="fas fa-map-marker-alt me-2"></i>{{ $identitas['alamat'] }}</p>
                    <!-- Tautan ke WhatsApp -->
                    <p class="mb-0"><i class="fab fa-whatsapp me-2"></i><a href="https://wa.me/62881027554000" target="_blank" rel="noopener">0881027554000</a></p>
                    <a class="btn-rute" href="https://www.google.com/maps/search/?api=1&query=Masjid+Roudlotul+Jannah" target="_blank" rel="noopener">Buka rute di Google Maps</a>
                </div>
                <div class="col-lg-7">
                    <div class="peta">
                        <iframe title="Lokasi Pagar Nusa Ranting Mancar Ulul-Albab" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.3405274572374!2d112.26983467492958!3d-7.537790092475572!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e786acdbf27352d%3A0x48c23b572fb6cb25!2sMasjid%20Roudlotul%20Jannah!5e0!3m2!1sid!2sid!4v1794794803679!5m2!1sid!2sid" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
                    </div>
                </div>
            </div>
            <div class="salin">&copy; {{ date('Y') }} {{ $identitas['nama_organisasi'] }}. All rights reserved.</div>
        </div>
    </footer>

    <!-- Bar aksi cepat, hanya tampil di HP -->
    <div class="bar-bawah">
        <a class="hubungi" href="https://wa.me/62881027554000" target="_blank" rel="noopener"><i class="fab fa-whatsapp me-1"></i> WhatsApp</a>
        <a class="daftar" href="/pendaftaran">Daftar sekarang</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        window.addEventListener('scroll', function() {
            document.getElementById('navbar').classList.toggle('scrolled', window.scrollY > 50);
        });

        // Tutup menu HP otomatis setelah memilih tautan
        document.querySelectorAll('#navbarNav .nav-link').forEach(function(link) {
            link.addEventListener('click', function() {
                var menu = document.getElementById('navbarNav');
                if (menu.classList.contains('show')) {
                    bootstrap.Collapse.getOrCreateInstance(menu).hide();
                }
            });
        });
    </script>
</body>
</html>