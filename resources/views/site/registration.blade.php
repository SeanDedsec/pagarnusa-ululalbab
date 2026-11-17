<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0f3d2e">
    <title>Pendaftaran Siswa Baru - {{ $identitas['nama_organisasi'] }}</title>
    
    <link rel="icon" type="image/png" href="{{ asset('img/logotab.png') }}">
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
            --radius: 16px;
        }

        body {
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            color: var(--tinta);
            background: var(--latar);
            line-height: 1.65;
            min-height: 100vh;
        }
        h1, h2, h3, h4, h5 { font-family: 'Fraunces', Georgia, serif; font-weight: 700; line-height: 1.2; letter-spacing: -0.01em; }
        a:focus-visible, button:focus-visible { outline: 3px solid var(--emas); outline-offset: 2px; }

        /* ---------- Kepala halaman ---------- */
        .kepala {
            background:
                radial-gradient(circle at 90% 0%, rgba(201,162,39,.22), transparent 40%),
                repeating-linear-gradient(135deg, rgba(255,255,255,.035) 0 2px, transparent 2px 22px),
                var(--hijau-tua);
            color: #fff;
            padding: 20px 0 96px;
            border-bottom: 4px solid var(--emas);
        }
        .kepala-atas { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 36px; }
        .brand { display: flex; align-items: center; gap: 12px; color: #fff; text-decoration: none; min-width: 0; }
        .brand img { width: 42px; height: 42px; border-radius: 50%; background: #fff; padding: 3px; object-fit: contain; flex-shrink: 0; }
        .brand-text { display: flex; flex-direction: column; line-height: 1.15; min-width: 0; }
        .brand-text strong { font-family: 'Fraunces', serif; font-size: 1.05rem; }
        .brand-text small { font-size: .72rem; color: rgba(255,255,255,.75); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .kembali { color: rgba(255,255,255,.9); text-decoration: none; font-weight: 600; font-size: .92rem; white-space: nowrap; padding: 8px 4px; }
        .kembali:hover { color: var(--emas); }
        .kepala h1 { font-size: clamp(1.8rem, 5.5vw, 2.8rem); margin-bottom: 10px; max-width: 20ch; }
        .kepala p.sub { color: rgba(255,255,255,.85); max-width: 50ch; margin: 0; }

        /* ---------- Isi ---------- */
        .isi { margin-top: -64px; padding-bottom: 56px; position: relative; z-index: 2; }
        .form-box {
            background: #fff; border-radius: 20px; padding: 24px 20px;
            box-shadow: 0 18px 40px -12px rgba(15,61,46,.28);
        }
        @media (min-width: 768px) { .form-box { padding: 36px; } }
        .form-box h2 { font-size: 1.3rem; color: var(--hijau-tua); margin-bottom: 4px; }
        .form-box .catatan { color: var(--abu); font-size: .92rem; margin-bottom: 22px; }

        .form-label { font-weight: 600; color: var(--hijau-tua); margin-bottom: 6px; }
        .form-control {
            font-size: 1rem; /* 16px agar iOS tidak memperbesar layar saat mengetik */
            padding: 13px 14px; border-radius: 12px; border: 1.5px solid var(--garis); background: #fcfdfc;
        }
        .form-control::placeholder { color: #98a59e; }
        .form-control:focus { border-color: var(--hijau); background: #fff; box-shadow: 0 0 0 4px rgba(29,107,79,.15); }
        .form-text { color: var(--abu); font-size: .84rem; }

        .btn-emas {
            background: var(--emas); color: #1c1700; font-weight: 700; font-size: 1.02rem;
            border: 0; border-radius: 999px; padding: 14px; width: 100%;
            transition: background .2s, transform .15s;
        }
        .btn-emas:hover { background: var(--emas-tua); color: #fff; }
        .btn-emas:active { transform: scale(.98); }

        .alert-galat { border: 0; border-left: 4px solid #b3322b; background: #fbeceb; color: #7d201b; border-radius: 12px; font-size: .92rem; }
        .alert-galat ul { margin: 0; padding-left: 18px; }

        /* ---------- Langkah setelah daftar (urutan nyata) ---------- */
        .langkah { padding: 8px 4px; }
        .langkah h3 { font-size: 1.15rem; color: var(--hijau-tua); margin-bottom: 18px; }
        .langkah ol { list-style: none; margin: 0; padding: 0; counter-reset: l; }
        .langkah li { position: relative; padding: 0 0 20px 46px; counter-increment: l; }
        .langkah li::before {
            content: counter(l); position: absolute; left: 0; top: 0;
            width: 32px; height: 32px; border-radius: 50%; background: var(--hijau); color: #fff;
            display: grid; place-items: center; font-weight: 700; font-size: .9rem;
        }
        .langkah li:not(:last-child)::after { content: ''; position: absolute; left: 15px; top: 36px; bottom: 4px; width: 2px; background: var(--garis); }
        .langkah li b { display: block; line-height: 1.35; }
        .langkah li span { color: var(--abu); font-size: .92rem; }
        @media (max-width: 767.98px) { .langkah { margin-top: 28px; } }

        /* ---------- Modal sukses ---------- */
        .modal-content { border: 0; border-radius: 22px; overflow: hidden; }
        .modal-title { font-family: 'Fraunces', serif; font-size: 1.5rem; color: var(--hijau-tua); }
        .ikon-sukses {
            width: 72px; height: 72px; border-radius: 50%; margin: 0 auto 16px;
            background: var(--hijau-pucat); color: var(--hijau);
            display: grid; place-items: center; font-size: 1.9rem;
        }
        .modal .btn-lg { border-radius: 999px; font-size: 1rem; font-weight: 700; padding: 13px 20px; }
        .modal .btn-success { background: #1f9d55; border-color: #1f9d55; }
        .modal .btn-outline-secondary { border-radius: 999px; font-weight: 600; }
        .modal-footer { border-top: 1px solid var(--garis); background: var(--latar); }

        @media (prefers-reduced-motion: reduce) { * { transition: none !important; } }
    </style>
</head>
<body>

    <header class="kepala">
        <div class="container">
            <div class="kepala-atas">
                <a class="brand" href="/">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Pagar Nusa"
                         onerror="this.onerror=null;this.src='data:image/svg+xml;utf8,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 40 40%27%3E%3Ccircle cx=%2720%27 cy=%2720%27 r=%2720%27 fill=%27%231d6b4f%27/%3E%3Ctext x=%2720%27 y=%2726%27 font-size=%2718%27 text-anchor=%27middle%27 fill=%27white%27 font-family=%27serif%27 font-weight=%27bold%27%3EPN%3C/text%3E%3C/svg%3E';">
                    <span class="brand-text">
                        <strong>Pagar Nusa</strong>
                        <small>{{ $identitas['nama_organisasi'] }}</small>
                    </span>
                </a>
                <a href="/" class="kembali">&larr; Beranda</a>
            </div>
            <h1>Pendaftaran Siswa Baru</h1>
            <p class="sub">Isi data calon siswa di bawah ini. Pengurus akan memeriksa data dan menghubungi Anda lewat WhatsApp.</p>
        </div>
    </header>

    <main class="isi">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <div class="col-lg-7">
                    <div class="form-box">

                        <h2>Data calon siswa</h2>
                        <p class="catatan">Semua kolom wajib diisi.</p>

                        @if($errors->any())
                        <div class="alert alert-galat" role="alert">
                            <ul>
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form action="/pendaftaran" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label" for="nama_siswa">Nama lengkap</label>
                                <input type="text" id="nama_siswa" name="nama_siswa" value="{{ old('nama_siswa') }}" class="form-control" placeholder="Masukkan nama lengkap" autocomplete="name" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="alamat">Alamat lengkap</label>
                                <textarea id="alamat" name="alamat" class="form-control" rows="3" placeholder="Contoh: Dusun Mancar, RT 01 RW 02" autocomplete="street-address" required>{{ old('alamat') }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="no_hp">Nomor HP (WhatsApp)</label>
                                    <input type="tel" inputmode="numeric" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" class="form-control" placeholder="08xxxxxxxxxx" autocomplete="tel" required>
                                    <div class="form-text">Nomor ini yang akan dihubungi pengurus.</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="tanggal_lahir">Tanggal lahir</label>
                                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="form-control" required>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-emas">Kirim pendaftaran</button>
                            </div>

                            <div class="text-center mt-3">
                                <a href="/" class="text-decoration-none" style="color: var(--hijau-tua);">
                                    &larr; Kembali ke Beranda
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-4 offset-lg-0">
                    <aside class="langkah">
                        <h3>Setelah mendaftar</h3>
                        <ol>
                            <li><b>Isi dan kirim formulir</b><span>Data Anda tersimpan dan langsung diterima pengurus.</span></li>
                            <li><b>Unduh bukti pendaftaran</b><span>Simpan sebagai tanda data sudah masuk.</span></li>
                            <li><b>Hubungi pelatih lewat WhatsApp</b><span>Pelatih akan mengonfirmasi dan menjelaskan langkah berikutnya.</span></li>
                        </ol>
                    </aside>
                </div>
            </div>
        </div>
    </main>

    @if(session('sukses'))
    <div class="modal fade" id="modalSuksesPendaftaran" tabindex="-1" aria-labelledby="judulSukses" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content text-center">
                <div class="modal-body p-4 p-md-5">
                    <div class="ikon-sukses"><i class="fas fa-check"></i></div>
                    <h5 class="modal-title" id="judulSukses">Pendaftaran Berhasil!</h5>
                    <p class="text-muted mt-2">Data Anda telah kami terima dan sedang menunggu konfirmasi Admin.</p>
                    <p class="fw-semibold">Silakan unduh bukti pendaftaran dan hubungi Pelatih Penanggung Jawab untuk informasi lebih lanjut.</p>

                    <div class="d-grid gap-2 mt-4">
                        <a href="/pendaftaran/bukti/{{ session('siswa_id') }}" class="btn btn-danger btn-lg">
                            <i class="fas fa-file-pdf me-2"></i> Download Bukti Pendaftaran
                        </a>

                        <!-- Tautan WhatsApp diubah ke nomor +62 896-7583-0547 -->
                        <a href="https://wa.me/6289675830547?text=Halo%20Pelatih,%20saya%20ingin%20konfirmasi%20pendaftaran%20siswa%20baru%20dengan%20ID%20%23PN-{{ str_pad(session('siswa_id'), 4, '0', STR_PAD_LEFT) }}%20atas%20nama%20..." target="_blank" rel="noopener" class="btn btn-success btn-lg">
                            <i class="fab fa-whatsapp me-2"></i> Hubungi Pelatih (WA)
                        </a>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <a href="/" class="btn btn-outline-secondary">Kembali ke Beranda</a>
                </div>
            </div>
        </div>
    </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @if(session('sukses'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var myModal = new bootstrap.Modal(document.getElementById('modalSuksesPendaftaran'));
            myModal.show();
        });
    </script>
    @endif
</body>
</html>