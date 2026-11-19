<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan</title>
    <style>
        /* PENGATURAN HALAMAN (A4, Margin Normal 2.54cm) */
        @page {
            size: A4 portrait;
            margin: 2.54cm; 
        }

        /* PENGATURAN FONT & SPASI UTAMA (Sesuai Permintaan: 12pt, Spasi 1.5) */
        body { 
            font-family: 'Times New Roman', Times, serif; 
            font-size: 12pt; 
            line-height: 1.5; 
            color: #000; 
            margin: 0;
            padding: 0;
        }
        
        /* Tabel Utama */
        table { width: 100%; border-collapse: collapse; }
        
        /* Ukuran Font Khusus Tabel Data (Dikecilkan agar 6 kolom muat di A4) */
        .table-data th, .table-data td { 
            border: 1px solid #000; 
            padding: 6px 8px; 
            font-size: 10pt; 
            line-height: 1.3; 
            vertical-align: middle;
        }
        .table-data th { 
            background-color: #eaeaea; 
            text-align: center; 
            font-weight: bold; 
        }
        
        /* Tanda Tangan */
        .ttd td { 
            text-align: center; 
            vertical-align: top; 
            font-size: 12pt; 
            line-height: 1.5;
        }
        
        /* Footer */
        .footer { 
            text-align: center; 
            font-size: 9pt; 
            color: #555; 
            line-height: 1.3;
        }
    </style>
</head>
<body>

    <!-- ================= HEADER (KOP SURAT) ================= -->
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <!-- Logo Kiri (IPSI) -->
            <td width="120" align="center" valign="middle">
                <img src="{{ public_path('img/logoipsi.png') }}" style="width: 2.8cm; height: 2.8cm;" alt="Logo IPSI">
            </td>

            <!-- Teks Tengah -->
            <td align="center" valign="middle">
                <span style="font-size: 14pt; font-weight: bold; line-height: 1.3;">
                    PIMPINAN RANTING<br>
                    PENCAK SILAT NAHDLATUL ULAMA PAGAR NUSA<br>
                    DESA MANCAR
                </span>
                <br>
                <span style="font-size: 10pt; font-style: italic; line-height: 1.2;">
                    Sekretariat : Pondok Pesantren Ulul Albab<br>
                    Desa Mancar – Kecamatan Peterongan – Kabupaten Jombang
                </span>
            </td>

            <!-- Logo Kanan (Pagar Nusa) -->
            <td width="120" align="center" valign="middle">
                <img src="{{ public_path('img/logopn.png') }}" style="width: 2.8cm; height: 2.8cm;" alt="Logo Pagar Nusa">
            </td>
        </tr>
    </table>

    <!-- Garis Ganda Kop Surat (Menggunakan Tabel seperti Referensi) -->
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td style="border-top: 3px solid black; font-size: 1px; line-height: 1px;">&nbsp;</td>
        </tr>
    </table>
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td style="border-top: 1px solid black; font-size: 1px; line-height: 1px; padding-top: 2px;">&nbsp;</td>
        </tr>
    </table>
    <br>

    <!-- ================= JUDUL LAPORAN ================= -->
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td align="center">
                <span style="font-size: 14pt; font-weight: bold; text-decoration: underline;">LAPORAN KEUANGAN</span>
            </td>
        </tr>
    </table>
    <br>

    <!-- ================= INFO LAPORAN ================= -->
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-size: 12pt; line-height: 1.5;">
        <tr>
            <td width="40%" align="left" valign="top">
                <strong>Periode</strong><br>
                {{ \Carbon\Carbon::parse($tanggal_mulai)->format('d F Y') }} s/d {{ \Carbon\Carbon::parse($tanggal_akhir)->format('d F Y') }}
            </td>
            <td width="20%" align="center" valign="top">
                <strong>Total Data</strong><br>
                {{ count($keuangan) }} Transaksi
            </td>
            <td width="40%" align="right" valign="top">
                <strong>Tanggal Cetak</strong><br>
                {{ date('d F Y H:i') }} WIB
            </td>
        </tr>
    </table>
    <br>

    <!-- ================= TABEL TRANSAKSI ================= -->
    <table class="table-data" width="100%" cellpadding="0" cellspacing="0" border="1">
        <thead>
            <tr>
                <th width="6%">No</th>
                <th width="15%">Tanggal</th>
                <th width="17%">Kategori</th>
                <th width="12%">Jenis</th>
                <th width="25%">Keterangan</th>
                <th width="25%">Nominal (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($keuangan as $index => $k)
            <tr>
                <td align="center">{{ $index + 1 }}</td>
                <td align="center">{{ \Carbon\Carbon::parse($k->tanggal)->format('d/m/Y') }}</td>
                <td>{{ $k->kategori }}</td>
                <td align="center">{{ ucfirst($k->jenis_transaksi) }}</td>
                <td>{{ $k->keterangan ?? '-' }}</td>
                <td align="right">{{ number_format($k->nominal, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" align="center" style="padding: 20px;">Tidak ada data transaksi pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <br>

    <!-- ================= TABEL RINGKASAN (Gaya Referensi) ================= -->
    <table width="100%" cellpadding="6" cellspacing="0" border="1" style="font-size: 11pt;">
        <tr>
            <td width="25%" style="background-color: #f8f9fa;"><strong>Total Pemasukan</strong></td>
            <td width="25%"><strong>Rp {{ number_format($totalMasuk, 0, ',', '.') }}</strong></td>
            <td width="25%" style="background-color: #f8f9fa;"><strong>Total Pengeluaran</strong></td>
            <td width="25%"><strong>Rp {{ number_format($totalKeluar, 0, ',', '.') }}</strong></td>
        </tr>
        <tr>
            <td colspan="3" align="right" style="background-color: #e0e0e0;"><strong>SALDO AKHIR</strong></td>
            <td style="background-color: #e0e0e0;"><strong>Rp {{ number_format($saldo, 0, ',', '.') }}</strong></td>
        </tr>
    </table>

    <br><br><br>

    <!-- ================= TANDA TANGAN ================= -->
    <div class="ttd">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td width="50%" align="center" valign="top">
                    Mengetahui,<br>
                    <strong>Ketua Pagar Nusa</strong><br>
                    Desa Mancar
                    <br><br><br><br>
                    <strong><u>(......................................)</u></strong>
                </td>
                <td width="50%" align="center" valign="top">
                    Jombang, {{ date('d F Y') }}<br>
                    <strong>Bendahara</strong>
                    <br><br><br><br>
                    <strong><u>(......................................)</u></strong>
                </td>
            </tr>
        </table>
    </div>

    <br><br>

    <!-- ================= FOOTER ================= -->
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td style="border-top: 1px solid #cccccc;" align="center" class="footer">
                <br>
                Dicetak dari Sistem Informasi Administrasi Pagar Nusa Ranting Mancar Ulul-Albab<br>
                &copy; {{ date('Y') }} Pimpinan Ranting Pagar Nusa Desa Mancar
            </td>
        </tr>
    </table>

</body>
</html>