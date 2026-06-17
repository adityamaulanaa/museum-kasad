<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>E-Ticket Museum KASAD</title>
   <style>
        body { 
            font-family: 'Helvetica', 'Arial', sans-serif; 
            background-color: #ffffff; 
            padding: 0px 20px; /* Margin kertas */
        }
        .ticket-container {
            background-color: #111111; 
            /* width: 100%; <-- Baris ini dihapus agar tidak meluber */
            border: 2px solid #d4af37; 
            border-radius: 15px;
            padding: 30px; /* Padding sedikit dikurangi agar lebih proporsional di A4 */
            margin-top: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 1px solid #333333;
            padding-bottom: 20px;
            margin-bottom: 25px;
        }
        .title { 
            color: #d4af37; 
            font-size: 28px; 
            font-weight: bold; 
            letter-spacing: 3px; 
            text-transform: uppercase; 
            margin: 0; 
        }
        .subtitle { 
            color: #aaaaaa; 
            font-size: 14px; 
            margin-top: 8px; 
            letter-spacing: 1px;
        }
        .content-table { 
            width: 100%; 
            border-collapse: collapse; 
        }
        .content-table td { 
            vertical-align: middle; 
        }
        .info-table {
            width: 100%;
        }
        .info-table td {
            padding: 10px 0;
            border-bottom: 1px dashed #333333;
        }
        .label { 
            color: #888888; 
            font-size: 12px; 
            text-transform: uppercase; 
            letter-spacing: 1px; 
            width: 40%; 
        }
        .value { 
            color: #ffffff; 
            font-size: 16px; 
            font-weight: bold; 
        }
        .value-gold { 
            color: #d4af37; 
            font-size: 18px; 
            font-weight: bold; 
        }
        .qr-wrapper {
            text-align: right;
        }
        .qr-container { 
            background-color: #ffffff; 
            padding: 10px; 
            border-radius: 10px; 
            display: inline-block; 
        }
        .qr-code { 
            width: 150px; 
            height: 150px; 
        }
        .footer { 
            text-align: center; 
            margin-top: 35px; 
            font-size: 13px; 
            color: #777777; 
            border-top: 1px solid #333333; 
            padding-top: 20px; 
            line-height: 1.5;
        }
    </style>
</head>
<body>

    <div class="ticket-container">
        <div class="header">
            <h1 class="title">MUSEUM KASAD</h1>
            <p class="subtitle">E-TICKET RESMI KUNJUNGAN PENGUNJUNG</p>
        </div>

        <table class="content-table">
            <tr>
                <td style="width: 60%;">
                    <table class="info-table">
                        <tr>
                            <td class="label">Kode Tiket</td>
                            <td class="value-gold">{{ $tiket->kode_tiket }}</td>
                        </tr>
                        <tr>
                            <td class="label">Nama Pemesan</td>
                            <td class="value">{{ $tiket->nama_pengunjung }}</td>
                        </tr>
                        <tr>
                            <td class="label">Tanggal Kunjungan</td>
                            <td class="value">{{ \Carbon\Carbon::parse($tiket->tgl_kunjungan)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</td>
                        </tr>
                        <tr>
                            <td class="label">Sesi Kunjungan</td>
                            <td class="value">{{ $tiket->sesi }}</td>
                        </tr>
                        <tr>
                            <td class="label" style="border-bottom: none;">Rincian Tiket</td>
                            <td class="value" style="border-bottom: none;">
                                @if($tiket->jumlah_dewasa > 0) {{ $tiket->jumlah_dewasa }} Dewasa @endif
                                @if($tiket->jumlah_mahasiswa > 0) | {{ $tiket->jumlah_mahasiswa }} Pelajar @endif
                                @if($tiket->jumlah_anak > 0) | {{ $tiket->jumlah_anak }} Anak @endif
                            </td>
                        </tr>
                    </table>
                </td>
                
                <td style="width: 40%;" class="qr-wrapper">
                    <div class="qr-container">
                        <img src="data:image/svg+xml;base64,{{ $qrcode }}" class="qr-code">
                    </div>
                </td>
            </tr>
        </table>

        <div class="footer">
            Tunjukkan e-ticket ini (melalui layar HP atau dicetak) kepada petugas di pintu masuk.<br>
            Tiket ini hanya berlaku 2 hari setelah tanggal kunjungan yang tertera di atas.
        </div>
    </div>

</body>
</html>