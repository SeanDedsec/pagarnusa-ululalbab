<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h2, .header h3 { margin: 0; }
        .header p { margin: 5px 0 0 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #e0e0e0; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .footer { margin-top: 30px; text-align: right; font-style: italic; font-size: 10px; }
    </style>
</head>
<body>

    <div class="header">
        <h2>PAGAR NUSA RANTING MANCAR ULUL-ALBAB</h2>
        <h3>Laporan Keuangan</h3>
        <p>Periode: {{ \Carbon\Carbon::parse($tanggal_mulai)->format('d F Y') }} s/d {{ \Carbon\Carbon::parse($tanggal_akhir)->format('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="15%">Tanggal</th>
                <th width="20%">Kategori</th>
                <th width="10%">Jenis</th>
                <th width="15%" class="text-right">Nominal (Rp)</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($keuangan as $index => $k)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($k->tanggal)->format('d/m/Y') }}</td>
                <td>{{ $k->kategori }}</td>
                <td>{{ ucfirst($k->jenis_transaksi) }}</td>
                <td class="text-right">{{ number_format($k->nominal, 0, ',', '.') }}</td>
                <td>{{ $k->keterangan ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada data transaksi pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="text-right">Total Pemasukan</th>
                <th class="text-right">{{ number_format($totalMasuk, 0, ',', '.') }}</th>
                <th></th>
            </tr>
            <tr>
                <th colspan="4" class="text-right">Total Pengeluaran</th>
                <th class="text-right">{{ number_format($totalKeluar, 0, ',', '.') }}</th>
                <th></th>
            </tr>
            <tr>
                <th colspan="4" class="text-right" style="background-color: #ccc;">Saldo Akhir</th>
                <th class="text-right" style="background-color: #ccc;">{{ number_format($saldo, 0, ',', '.') }}</th>
                <th></th>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        Dicetak secara otomatis oleh Sistem Informasi Pagar Nusa pada: {{ date('d F Y H:i') }}
    </div>

</body>
</html>