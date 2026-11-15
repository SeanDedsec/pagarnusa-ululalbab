<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Siswa Baru - {{ $identitas['nama_organisasi'] }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --hijau-tua: #0b3d2e;
            --hijau-muda: #145a43;
            --emas: #d4af37;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7f6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .card-pendaftaran {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 600px;
            width: 100%;
        }

        .card-header-custom {
            background-color: var(--hijau-tua);
            color: white;
            text-align: center;
            padding: 30px 20px;
            border-bottom: 5px solid var(--emas);
        }

        .btn-emas {
            background-color: var(--emas);
            color: #000;
            font-weight: 600;
            border-radius: 30px;
            padding: 12px;
            width: 100%;
            border: none;
            transition: 0.3s;
        }

        .btn-emas:hover {
            background-color: #b8962e;
        }

        .form-label {
            font-weight: 600;
            color: var(--hijau-tua);
        }

        .form-control:focus {
            border-color: var(--emas);
            box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.25);
        }
    </style>
</head>
<body>

    <div class="card card-pendaftaran">
        <div class="card-header-custom">
            <h3 class="mb-1">Pendaftaran Siswa Baru</h3>
            <p class="mb-0 text-white-50">{{ $identitas['nama_organisasi'] }}</p>
        </div>
        
        <div class="card-body p-4 p-md-5">
            @if(session('sukses'))
            <div class="modal fade" id="modalSuksesPendaftaran" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content text-center">
                        <div class="modal-header bg-success text-white justify-content-center">
                            <h5 class="modal-title fw-bold">Pendaftaran Berhasil!</h5>
                        </div>
                        <div class="modal-body p-4">
                            <i class="fas fa-check-circle text-success mb-3" style="font-size: 4rem;"></i>
                            <p>Data Anda telah kami terima dan sedang menunggu konfirmasi Admin.</p>
                            <p class="fw-bold">Silakan unduh bukti pendaftaran dan hubungi Pelatih Penanggung Jawab untuk informasi lebih lanjut.</p>
                            
                            <div class="d-grid gap-2 mt-4">
                                <a href="/pendaftaran/bukti/{{ session('siswa_id') }}" class="btn btn-danger btn-lg">
                                    <i class="fas fa-file-pdf me-2"></i> Download Bukti Pendaftaran
                                </a>
                                
                                <a href="https://wa.me/62{{ ltrim(session('no_hp_pelatih'), '0') }}?text=Halo%20Pelatih,%20saya%20ingin%20konfirmasi%20pendaftaran%20siswa%20baru%20dengan%20ID%20%23PN-{{ str_pad(session('siswa_id'), 4, '0', STR_PAD_LEFT) }}%20atas%20nama%20..." target="_blank" class="btn btn-success btn-lg">
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
            
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var myModal = new bootstrap.Modal(document.getElementById('modalSuksesPendaftaran'));
                    myModal.show();
                });
            </script>
            @endif
                
            <form action="/pendaftaran" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama_siswa" class="form-control" placeholder="Masukkan nama lengkap" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat Lengkap</label>
                    <textarea name="alamat" class="form-control" rows="3" placeholder="Contoh: Dusun Mancar, RT 01 RW 02" required></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nomor HP (WhatsApp)</label>
                        <input type="number" name="no_hp" class="form-control" placeholder="08xxxxxxxxxx" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control" required>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-emas">Kirim Pendaftaran</button>
                </div>
                
                <div class="text-center mt-3">
                    <a href="/" class="text-decoration-none" style="color: var(--hijau-tua);">
                        &larr; Kembali ke Beranda
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>