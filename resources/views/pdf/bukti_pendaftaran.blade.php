<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bukti Pendaftaran</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #000; padding-bottom: 15px; }
        .header h1, .header h2 { margin: 0; }
        .content { margin: 20px; }
        .content table { width: 100%; margin-top: 20px; }
        .content td { padding: 8px 0; }
        .status { background-color: #ffc107; padding: 10px; text-align: center; font-weight: bold; margin-top: 20px; border-radius: 5px; }
        .footer { margin-top: 50px; text-align: center; font-size: 12px; font-style: italic; }
    </style>
</head>
<body>

    <div class="header">
        <h1>PAGAR NUSA RANTING MANCAR ULUL-ALBAB</h1>
        <h2>Bukti Pendaftaran Siswa Baru</h2>
    </div>

    <div class="content">
        <p>Terima kasih telah melakukan pendaftaran. Berikut adalah detail data pendaftaran Anda:</p>
        <table>
            <tr>
                <td width="30%"><strong>ID Pendaftaran</strong></td>
                <td>: #PN-{{ str_pad($siswa->id, 4, '0', STR_PAD_LEFT) }}</td>
            </tr>
            <tr>
                <td><strong>Nama Lengkap</strong></td>
                <td>: {{ $siswa->nama_siswa }}</td>
            </tr>
            <tr>
                <td><strong>Alamat</strong></td>
                <td>: {{ $siswa->alamat }}</td>
            </tr>
            <tr>
                <td><strong>No. HP</strong></td>
                <td>: {{ $siswa->no_hp }}</td>
            </tr>
            <tr>
                <td><strong>Tanggal Lahir</strong></td>
                <td>: {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d F Y') }}</td>
            </tr>
        </table>

        <div class="status">
            STATUS: MENUNGGU KONFIRMASI ADMIN
        </div>

        <p style="margin-top: 30px; font-size: 12px;">
            <strong>Instruksi:</strong><br>
            1. Silakan hubungi Pelatih Penanggung Jawab untuk melakukan konfirmasi dan administrasi.<br>
            2. Simpan bukti pendaftaran ini sebagai syarat validasi.
        </p>
    </div>

    <div class="footer">
        Dicetak pada: {{ date('d F Y H:i') }}<br>
        Sistem Informasi Pagar Nusa Ulul-Albab
    </div>

</body>
</html>