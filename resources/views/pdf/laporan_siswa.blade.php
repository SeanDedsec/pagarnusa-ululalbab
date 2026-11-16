<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Siswa</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h2, .header h3 { margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #e0e0e0; }
        .text-center { text-align: center; }
        .footer { margin-top: 30px; text-align: right; font-style: italic; font-size: 10px; }
    </style>
</head>
<body>

    <div class="header">
        <h2>PAGAR NUSA RANTING MANCAR ULUL-ALBAB</h2>
        <h3>Laporan Data Siswa</h3>
        <p>Dicetak pada: {{ date('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="25%">Nama Siswa</th>
                <th width="15%">No. HP</th>
                <th width="10%">Tgl Lahir</th>
                <th width="30%">Alamat</th>
                <th width="15%" class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($siswa as $index => $s)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $s->nama_siswa }}</td>
                <td>{{ $s->no_hp }}</td>
                <td>{{ \Carbon\Carbon::parse($s->tanggal_lahir)->format('d/m/Y') }}</td>
                <td>{{ $s->alamat }}</td>
                <td class="text-center">{{ ucfirst($s->status) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Belum ada data siswa.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak secara otomatis oleh Sistem Informasi Pagar Nusa
    </div>

</body>
</html>