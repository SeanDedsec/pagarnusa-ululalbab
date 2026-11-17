<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0f3d2e">
    <title>Login Admin - Pagar Nusa</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
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
        }

        body {
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            color: var(--tinta);
            background: var(--hijau-tua);
            min-height: 100vh;
            min-height: 100dvh;
            margin: 0;
        }
        h1, h2, h3 { font-family: 'Fraunces', Georgia, serif; font-weight: 700; letter-spacing: -0.01em; line-height: 1.2; }
        a:focus-visible, button:focus-visible { outline: 3px solid var(--emas); outline-offset: 2px; }

        .login-wrap { min-height: 100vh; min-height: 100dvh; display: flex; flex-direction: column; }

        /* ---------- Panel merek ---------- */
        .panel-merek {
            background:
                radial-gradient(circle at 90% 0%, rgba(201,162,39,.22), transparent 42%),
                repeating-linear-gradient(135deg, rgba(255,255,255,.035) 0 2px, transparent 2px 22px),
                var(--hijau-tua);
            color: #fff;
            padding: 32px 24px 64px;
            border-bottom: 4px solid var(--emas);
        }
        .logo { width: 64px; height: 64px; border-radius: 50%; background: #fff; padding: 4px; object-fit: contain; }
        .panel-merek .nama { font-family: 'Fraunces', serif; font-size: 1.15rem; color: var(--emas); margin: 14px 0 0; }
        .panel-merek h1 { font-size: 1.7rem; margin: 6px 0 8px; }
        .panel-merek p { color: rgba(255,255,255,.8); margin: 0; max-width: 40ch; }
        .panel-merek .desk { display: none; }

        /* ---------- Panel form ---------- */
        .panel-form {
            flex: 1;
            background: #fff;
            margin-top: -28px;
            border-radius: 28px 28px 0 0;
            padding: 32px 24px 28px;
            position: relative;
        }
        .form-isi { width: 100%; max-width: 400px; margin: 0 auto; }
        .form-isi h2 { font-size: 1.5rem; color: var(--hijau-tua); margin-bottom: 4px; }
        .form-isi .sub { color: var(--abu); font-size: .93rem; margin-bottom: 24px; }

        .form-label { font-weight: 600; color: var(--hijau-tua); margin-bottom: 6px; }
        .form-control {
            font-size: 1rem;
            padding: 13px 14px; border-radius: 12px; border: 1.5px solid var(--garis); background: #fcfdfc;
        }
        .form-control:focus { border-color: var(--hijau); background: #fff; box-shadow: 0 0 0 4px rgba(29,107,79,.15); }
        .form-control:disabled { background-color: #e9ecef; cursor: not-allowed; border-color: #dc3545; }

        .input-ikon { position: relative; }
        .input-ikon .form-control { padding-left: 44px; }
        .input-ikon > i.ikon { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--abu); pointer-events: none; }
        .input-ikon > i.ikon.lock { color: #dc3545; } /* Warna merah jika terkunci */
        
        .input-ikon .form-control.pw { padding-right: 52px; }
        .toggle-pw {
            position: absolute; right: 6px; top: 50%; transform: translateY(-50%);
            width: 42px; height: 42px; border: 0; background: transparent; color: var(--abu); border-radius: 10px;
        }
        .toggle-pw:hover { background: var(--hijau-pucat); color: var(--hijau-tua); }
        .toggle-pw:disabled { opacity: 0.5; cursor: not-allowed; }

        .btn-emas {
            background-color: var(--emas); color: #1c1700; font-weight: 700; font-size: 1.02rem;
            border: 0; border-radius: 999px; padding: 14px;
            transition: background .2s, transform .15s;
        }
        .btn-emas:hover { background-color: var(--emas-tua); color: #fff; }
        .btn-emas:active { transform: scale(.98); }
        .btn-emas:disabled { background-color: #a8861a; opacity: 0.6; cursor: not-allowed; }

        .alert-galat {
            border: 0; border-left: 4px solid #b3322b; background: #fbeceb; color: #7d201b;
            border-radius: 12px; font-size: .93rem; display: flex; gap: 10px; align-items: flex-start;
        }
        .alert-galat i { margin-top: 3px; }

        .kembali { display: inline-block; margin-top: 22px; color: var(--hijau); font-weight: 600; text-decoration: none; font-size: .92rem; }
        .kembali:hover { color: var(--hijau-tua); text-decoration: underline; }

        /* ---------- Desktop: dua kolom ---------- */
        @media (min-width: 992px) {
            .login-wrap { flex-direction: row; }
            .panel-merek {
                flex: 1 1 52%; display: flex; flex-direction: column; justify-content: center;
                padding: 64px; border-bottom: 0; border-right: 4px solid var(--emas);
            }
            .logo { width: 84px; height: 84px; }
            .panel-merek h1 { font-size: 2.6rem; margin: 10px 0 14px; max-width: 14ch; }
            .panel-merek .desk { display: block; font-size: 1.05rem; }
            .panel-form {
                flex: 1 1 48%; margin-top: 0; border-radius: 0; padding: 48px;
                display: flex; align-items: center;
            }
        }

        @media (prefers-reduced-motion: reduce) { * { transition: none !important; } }
    </style>
</head>
<body>

    <div class="login-wrap">
        <div class="panel-merek">
            <img class="logo" src="{{ asset('images/logo.png') }}" alt="Logo Pagar Nusa"
                 onerror="this.onerror=null;this.src='data:image/svg+xml;utf8,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 40 40%27%3E%3Ccircle cx=%2720%27 cy=%2720%27 r=%2720%27 fill=%27%231d6b4f%27/%3E%3Ctext x=%2720%27 y=%2726%27 font-size=%2718%27 text-anchor=%27middle%27 fill=%27white%27 font-family=%27serif%27 font-weight=%27bold%27%3EPN%3C/text%3E%3C/svg%3E';">
            <div class="nama">Pagar Nusa</div>
            <h1>Panel Admin</h1>
            <p class="desk">Kelola data siswa, pelatih, absensi, kegiatan, dan keuangan Ranting Mancar Ulul-Albab dalam satu tempat.</p>
        </div>

        <div class="panel-form">
            <div class="form-isi">
                <h2>Admin Login</h2>
                <p class="sub">Masuk dengan akun pengurus Anda.</p>

                @if($errors->any())
                    <div class="alert alert-galat" role="alert">
                        <i class="fas fa-circle-exclamation"></i>
                        <div>{{ $errors->first() }}</div>
                    </div>
                @endif

                <form action="/admin/login" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="username">Username</label>
                        <div class="input-ikon">
                            <!-- Jika session blocked ada, ganti ikon ke gembok -->
                            <i class="fas {{ session('blocked') ? 'fa-lock lock' : 'fa-user' }} ikon"></i>
                            <input type="text" id="username" name="username" value="{{ old('username') }}" class="form-control" autocomplete="username" autocapitalize="none" spellcheck="false" required {{ session('blocked') ? 'disabled' : 'autofocus' }}>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">Password</label>
                        <div class="input-ikon">
                            <i class="fas {{ session('blocked') ? 'fa-lock lock' : 'fa-lock' }} ikon"></i>
                            <input type="password" id="password" name="password" class="form-control pw" autocomplete="current-password" required {{ session('blocked') ? 'disabled' : '' }}>
                            <button type="button" class="toggle-pw" id="togglePw" aria-label="Tampilkan password" aria-pressed="false" {{ session('blocked') ? 'disabled' : '' }}>
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-emas w-100 mt-3" {{ session('blocked') ? 'disabled' : '' }}>
                        {{ session('blocked') ? 'Akses Diblokir Sementara' : 'Masuk' }}
                    </button>
                </form>

                <a href="/" class="kembali">&larr; Kembali ke situs</a>
            </div>
        </div>
    </div>

    <!-- MODAL PERINGATAN (SISA 1 PERCOBAAN) -->
    @if(session('warning_attempt'))
    <div class="modal fade" id="modalWarning" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-warning text-dark border-0">
                    <h5 class="modal-title fw-bold"><i class="fas fa-exclamation-triangle"></i> Peringatan Keamanan</h5>
                </div>
                <div class="modal-body text-center p-4">
                    <i class="fas fa-user-shield text-warning mb-3" style="font-size: 4rem;"></i>
                    <h5 class="fw-bold">Login Gagal!</h5>
                    <p>{{ session('warning_attempt') }}</p>
                </div>
                <div class="modal-footer justify-content-center border-0">
                    <button type="button" class="btn btn-warning px-4" data-bs-dismiss="modal">Mengerti</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var myModal = new bootstrap.Modal(document.getElementById('modalWarning'));
            myModal.show();
        });
    </script>
    @endif

    <!-- MODAL BLOKIR (SALAH 3 KALI) -->
    @if(session('blocked'))
    <div class="modal fade" id="modalBlocked" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-danger text-white border-0">
                    <h5 class="modal-title fw-bold"><i class="fas fa-ban"></i> Akses Diblokir</h5>
                </div>
                <div class="modal-body text-center p-4">
                    <i class="fas fa-lock text-danger mb-3" style="font-size: 4rem;"></i>
                    <h5 class="fw-bold">IP Anda Diblokir!</h5>
                    <p>{{ session('blocked') }}</p>
                    <div class="alert alert-danger py-2 mt-3 small">
                        Sistem mendeteksi aktivitas mencurigakan (Brute Force). Silakan hubungi Super Admin jika ini kesalahan.
                    </div>
                </div>
                <div class="modal-footer justify-content-center border-0">
                    <button type="button" class="btn btn-danger px-4" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var myModal = new bootstrap.Modal(document.getElementById('modalBlocked'));
            myModal.show();
        });
    </script>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (function () {
            var tombol = document.getElementById('togglePw');
            var input = document.getElementById('password');
            if(tombol) {
                tombol.addEventListener('click', function () {
                    var tampil = input.type === 'password';
                    input.type = tampil ? 'text' : 'password';
                    tombol.setAttribute('aria-pressed', tampil);
                    tombol.setAttribute('aria-label', tampil ? 'Sembunyikan password' : 'Tampilkan password');
                    tombol.firstElementChild.className = tampil ? 'fas fa-eye-slash' : 'fas fa-eye';
                });
            }
        })();
    </script>
</body>
</html>