<!DOCTYPE html>
<html>

<head>
    <title>Laporan Koleksi Museum KASAD</title>
    <style>
        body {
            font-family: sans-serif;
            color: #333;
            margin: 20px;
        }

        .kop-surat {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }

        .kop-surat h2 {
            margin: 0;
            font-size: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .kop-surat p {
            margin: 5px 0 0 0;
            font-size: 12px;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        table th {
            background-color: #f2f2f2;
            border: 1px solid #000;
            padding: 8px;
            font-weight: bold;
            text-transform: uppercase;
        }

        table td {
            border: 1px solid #000;
            padding: 8px;
            vertical-align: top;
        }

        .text-center {
            text-align: center;
        }

        .img-koleksi {
            width: 80px;
            height: auto;
            border-radius: 4px;
        }
    </style>
</head>

<body>

    <div class="kop-surat">
        <h2>Data Koleksi </h2>
        <h2>Museum KASAD</h2>
        <p>Dicetak otomatis oleh Sistem Manajemen Museum pada: {{ date('d-m-Y H:i') }} WIB</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Foto</th>
                <th width="20%">Nama Barang</th>
                <th width="15%">Kategori</th>
                <th width="10%">Tahun</th>
                <th width="15%">Bahan</th>
                <th width="20%">Asal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($barangs as $index => $b)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">
                        @if ($b->gambar_barang && file_exists(public_path('images/koleksi/' . $b->gambar_barang)))
                            @php
                                $imagePath = public_path('images/koleksi/' . $b->gambar_barang);
                                $imageData = base64_encode(file_get_contents($imagePath));

                                $extension = pathinfo($imagePath, PATHINFO_EXTENSION);

                                $base64Image = 'data:image/' . $extension . ';base64,' . $imageData;
                            @endphp

                            <img src="{{ $base64Image }}" class="img-koleksi">
                        @else
                            <span style="color: #999; font-style: italic; font-size: 10px;">Tidak ada foto</span>
                        @endif
                    </td>
                    <td><strong>{{ $b->nama_barang }}</strong></td>
                    <td>{{ $b->kategori_barang }}</td>
                    <td class="text-center">{{ $b->tahun_barang }}</td>
                    <td>{{ $b->bahan_barang }}</td>
                    <td>{{ $b->asal_barang }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
