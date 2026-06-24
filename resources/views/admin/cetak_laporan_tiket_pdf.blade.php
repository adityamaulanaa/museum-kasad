<!DOCTYPE html>
<html>

<head>
    <title>Laporan Pemesanan Tiket Museum KASAD</title>
    <style>
        body {
            font-family: sans-serif;
            color: #333;
            margin: 15px;
        }

        .kop-surat {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 8px;
            margin-bottom: 25px;
        }

        .kop-surat h2 {
            margin: 0;
            font-size: 20px;
            text-transform: uppercase;
        }

        .kop-surat p {
            margin: 5px 0 0 0;
            font-size: 11px;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        table th {
            background-color: #f2f2f2;
            border: 1px solid #000;
            padding: 7px 5px;
            font-weight: bold;
            text-transform: uppercase;
        }

        table td {
            border: 1px solid #000;
            padding: 7px 5px;
            vertical-align: middle;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .font-mono {
            font-family: monospace;
            font-weight: bold;
        }

        .status-badge {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 9px;
        }

        .kolom-sebaris {
            white-space: nowrap;
        }
    </style>
</head>

<body>

    <div class="kop-surat">
        <h2>Laporan Riwayat Kunjungan & Pemesanan Tiket</h2>
        <h2>Museum KASAD</h2>
        <p>Dicetak otomatis oleh Sistem Manajemen Museum pada: {{ date('d-m-Y H:i') }} WIB</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="12%">Kode Tiket</th>
                <th width="18%">Nama Pengunjung</th>
                <th width="18%">Kontak (Email/Telp)</th>
                <th width="12%">Rincian Tiket</th>
                <th width="10%">Tgl Beli</th>
                <th width="10%">Tgl Kunjungan</th>
                <th width="5%">Sesi</th>
                <th width="8%">Status</th>
                <th width="11%">Total Bayar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tikets as $index => $t)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="font-mono text-center">{{ $t->kode_tiket ?? '-' }}</td>
                    
                    <td>{{ $t->nama_pengunjung }}</td>
                    <td>
                        <div style="font-size: 10px; word-break: break-word;">{{ $t->email }}</div>
                        <div style="color: #666; font-size: 10px;">{{ $t->no_telp }}</div>
                    </td>
                    
                    <td class="kolom-sebaris">
                        @if (intval($t->jumlah_dewasa) > 0)
                            <div>{{ $t->jumlah_dewasa }}x Dewasa</div>
                        @endif
                        @if (intval($t->jumlah_anak) > 0)
                            <div>{{ $t->jumlah_anak }}x Anak</div>
                        @endif
                        @if (intval($t->jumlah_mahasiswa) > 0)
                            <div>{{ $t->jumlah_mahasiswa }}x Mahasiswa</div>
                        @endif
                    </td>
                    
                    <td class="text-center kolom-sebaris">{{ $t->tgl_beli ? explode(' ', $t->tgl_beli)[0] : '-' }}</td>
                    <td class="text-center kolom-sebaris">{{ $t->tgl_kunjungan ? explode(' ', $t->tgl_kunjungan)[0] : '-' }}</td>
                    <td class="text-center" style="text-transform: uppercase;">{{ $t->sesi ?? '-' }}</td>
                    <td class="text-center status-badge kolom-sebaris">
                        @if ($t->status_tiket === 'Sudah Dipakai')
                            <span style="color: #15803d;">Sudah Dipakai</span>
                        @elseif($t->status_tiket === 'Belum Dipakai')
                            <span style="color: #a16207;">Belum Dipakai</span>
                        @else
                            <span style="color: #b91c1c;">Expired</span>
                        @endif
                    </td>
                    <td class="font-mono text-right kolom-sebaris">Rp{{ number_format($t->total_harga, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>