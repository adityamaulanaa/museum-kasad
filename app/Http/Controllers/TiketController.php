<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tiket;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TiketController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi Kapasitas Maksimal (Maks 50 Pengunjung)
        $kapasitasMaksimal = 50;
        
        $jumlahTerpesan = Tiket::where('tgl_kunjungan', $request->tgl_kunjungan)
                                ->where('sesi', $request->sesi)
                                ->sum(DB::raw('jumlah_dewasa + jumlah_mahasiswa + jumlah_anak'));

        $totalBaru = $request->jumlah_dewasa + $request->jumlah_mahasiswa + $request->jumlah_anak;

        // Jika melebihi 50, batalkan dan kirim peringatan
        if (($jumlahTerpesan + $totalBaru) > $kapasitasMaksimal) {
            return back()->with('error', 'Maaf, ' . $request->sesi . ' pada tanggal tersebut sudah penuh! Sisa kuota: ' . ($kapasitasMaksimal - $jumlahTerpesan) . ' orang.');
        }

        // 2. Buat Kode Unik & Atur Kedaluwarsa (2 Hari dari Waktu Kunjungan)
        $kode_tiket = 'KASAD' . date('Ymd') . rand(1000, 9999);
        $expired_at = Carbon::parse($request->tgl_kunjungan)->addDays(1);

        // 3. Simpan Data Ke Database
        $tiket = Tiket::create([
            'kode_tiket'        => $kode_tiket,
            'nama_pengunjung'   => $request->nama_pengunjung,
            'no_telp'           => $request->no_telp,
            'email'             => $request->email,
            'jumlah_dewasa'     => $request->jumlah_dewasa,
            'jumlah_mahasiswa'  => $request->jumlah_mahasiswa,
            'jumlah_anak'       => $request->jumlah_anak,
            'tgl_kunjungan'     => $request->tgl_kunjungan,
            'metode_pembayaran' => $request->metode_pembayaran,
            'total_harga'       => $request->total_harga,
            'status_tiket'      => 'Belum Dipakai',
            'sesi'              => $request->sesi,
            'expired_at'        => $expired_at,
        ]);

        return redirect()->route('tiket.sukses', $tiket->id_tiket);
    }

    public function sukses($id)
    {
        $tiket = Tiket::findOrFail($id);
        return view('tiket-berhasil', compact('tiket'));
    }

    public function checkIn($id)
    {
        $tiket = Tiket::findOrFail($id);
        
        // VALIDASI KEDALUWARSA: Cek berdasarkan tanggal hari ini (hanya Y-m-d agar sinkron dengan frontend)
        $hariIni = \Carbon\Carbon::today();
        $tglExpired = \Carbon\Carbon::parse($tiket->expired_at)->startOfDay();

        if ($hariIni->gt($tglExpired)) {
            return redirect()->back()->with('error', 'Tiket ' . $tiket->kode_tiket . ' Gagal Check-in karena sudah kedaluwarsa!');
        }
        
        // Tambahan proteksi: Jika tiket sudah pernah dipakai sebelumnya
        if ($tiket->status_tiket === 'Sudah Dipakai') {
            return redirect()->back()->with('error', 'Tiket ' . $tiket->kode_tiket . ' sudah pernah digunakan!');
        }
        
        $tiket->update([
            'status_tiket' => 'Sudah Dipakai'
        ]);

        return redirect()->back()->with('success', 'Tiket ' . $tiket->kode_tiket . ' berhasil di-Check-in!');
    }

    public function cetakPDF($id)
    {
        $tiket = \App\Models\Tiket::findOrFail($id);
        
        // 1. Buat rincian tiket untuk QR Code
        $rincian = [];
        if($tiket->jumlah_dewasa > 0) $rincian[] = $tiket->jumlah_dewasa . ' Dewasa';
        if($tiket->jumlah_mahasiswa > 0) $rincian[] = $tiket->jumlah_mahasiswa . ' Pelajar';
        if($tiket->jumlah_anak > 0) $rincian[] = $tiket->jumlah_anak . ' Anak';
        $rincian_tiket = implode(', ', $rincian);

        // 2. Data QR Code (Sama seperti di tampilan web)
        $dataQr = json_encode([
            'Kode' => $tiket->kode_tiket,
            'Nama' => $tiket->nama_pengunjung,
            'Sesi' => $tiket->sesi,
            'Tanggal' => \Carbon\Carbon::parse($tiket->tgl_kunjungan)->format('d-m-Y'),
            'Tiket' => $rincian_tiket,
            'Total' => 'Rp ' . number_format($tiket->total_harga, 0, ',', '.')
        ]);

        // 3. Ubah QR Code menjadi format gambar (Base64) agar bisa dibaca oleh PDF
        $qrcode = base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(150)->generate($dataQr));

        // 4. Proses pembuatan PDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('tiket-pdf', compact('tiket', 'qrcode'));
        
        // 5. Unduh otomatis
        return $pdf->download('Tiket-Museum-KASAD-' . $tiket->kode_tiket . '.pdf');
    }

    public function cetakLaporanPdf()
    {
        // Ambil data tiket. Asumsi nama model kamu adalah Tiket
        $tikets = \App\Models\Tiket::orderBy('tgl_kunjungan', 'desc')->get();
        
        // Konversi status tiket secara dinamis di backend untuk data expired (meniru logika Javascript di halaman blade)
        $hariIni = date('d-m-Y');
        foreach ($tikets as $t) {
            if ($t->status_tiket === 'Belum Dipakai' && $t->expired_at && date('d-m-Y', strtotime($t->expired_at)) < $hariIni) {
                $t->status_tiket = 'Expired';
            }
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.cetak_laporan_tiket_pdf', compact('tikets'));
        $pdf->setPaper('a4', 'landscape'); // Set Landscape agar tabel data muat lebar ke samping

        return $pdf->download('Laporan_Pemesanan_Tiket_Museum_' . date('dmY') . '.pdf');
    }
}