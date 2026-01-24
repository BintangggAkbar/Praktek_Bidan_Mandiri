<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan - Bidan</title>
    <style>
        body { font-family: sans-serif; line-height: 1.5; color: #333; }
        .container { width: 100%; max-width: 800px; margin: 0 auto; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 24px; text-transform: uppercase; }
        .header p { margin: 5px 0 0; font-size: 14px; }
        .report-title { text-align: center; font-size: 18px; font-weight: bold; margin-bottom: 5px; text-transform: uppercase; }
        .report-period { text-align: center; font-size: 14px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 12px; }
        table th, table td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        table th { background-color: #f2f2f2; font-weight: bold; }
        .text-right { text-align: right; }
        .footer { margin-top: 30px; text-align: right; font-size: 12px; }
        @media print {
            .no-print { display: none; }
            body { -webkit-print-color-adjust: exact; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="container">
        <div class="header">
            <h1>MELATI IKA</h1>
        </div>

        <div class="report-title">
             @switch($type)
                @case('kunjungan') Laporan Kunjungan Pasien @break
                @case('penyakit') Rekap Kasus Penyakit @break
                @case('obat') Laporan Penggunaan Obat @break
                @case('rekam_medis_saya') Rekam Medis Saya @break
            @endswitch
        </div>
        <div class="report-period">
            Periode: {{ $startDate->translatedFormat('d F Y') }} - {{ $endDate->translatedFormat('d F Y') }}
        </div>

        @if($type === 'kunjungan')
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jumlah Kunjungan</th>
                        <th class="text-right">Jenis Layanan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $item)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($item->date)->translatedFormat('l, d F Y') }}</td>
                        <td>{{ $item->total_visits }} Pasien</td>
                        <td class="text-right">{{ $item->nama_layanan }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @elseif($type === 'penyakit')
             <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Diagnosa Penyakit</th>
                        <th class="text-right">Jumlah Kasus</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $index => $item)
                    <tr>
                        <td style="width: 50px;">{{ $index + 1 }}</td>
                        <td>{{ $item->diagnosis }}</td>
                        <td class="text-right">{{ $item->count }} Kasus</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @elseif($type === 'obat')
             <table>
                <thead>
                    <tr>
                        <th>Nama Obat</th>
                        <th class="text-right">Jumlah Terpakai</th>
                        <th class="text-right">Sisa Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $item)
                    <tr>
                        <td>{{ $item->nama_obat }}</td>
                        <td class="text-right">{{ $item->total_used }}</td>
                        <td class="text-right">{{ $item->stok }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @elseif($type === 'rekam_medis_saya')
             <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Pasien</th>
                        <th>Diagnosa</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $record)
                    <tr>
                        <td>{{ $record->created_at->translatedFormat('d/m/Y H:i') }}</td>
                        <td>{{ $record->pasien->nama_pasien }}</td>
                        <td>{{ $record->diagnosis }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <div class="footer">
            <p>Dicetak oleh: {{ Auth::user()->nama_lengkap }}</p>
            <p>Tanggal Cetak: {{ now()->translatedFormat('d F Y H:i') }}</p>
        </div>
    </div>
</body>
</html>
