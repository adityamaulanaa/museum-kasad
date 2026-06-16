<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tiket; // Memanggil model database Anda

class TiketController extends Controller
{
    // Fungsi untuk menangkap data klik "Bayar Sekarang"
    public function store(Request $request)
    {
        // 1. Membuat kode unik (Contoh: KASAD202605114829)
        $kode_tiket = 'KASAD' . date('Ymd') . rand(1000, 9999);

        // 2. Menyimpan data ke tabel database
        $tiket = \App\Models\Tiket::create([
        'kode_tiket'        => $kode_tiket, // <- Jangan sampai terlewat
        'nama_pengunjung'   => $request->nama_pengunjung,
        'no_telp'           => $request->no_telp,
        'email'             => $request->email,
        'jumlah_dewasa'     => $request->jumlah_dewasa,
        'jumlah_mahasiswa'  => $request->jumlah_mahasiswa,
        'jumlah_anak'       => $request->jumlah_anak,
        'tgl_kunjungan'     => $request->tgl_kunjungan,
        'metode_pembayaran' => $request->metode_pembayaran,
        'total_harga'       => $request->total_harga, // <- Jangan sampai terlewat
    ]);

        // 3. Pindah ke halaman Sukses dengan membawa ID tiket yang baru dibuat
        return redirect()->route('tiket.sukses', $tiket->id_tiket);
    }

    // Fungsi untuk menampilkan halaman berhasil
    public function sukses($id)
    {
        // Mencari data tiket tersebut di database
        $tiket = Tiket::findOrFail($id);
        
        // Membuka view tiket-berhasil sambil mengirim data tiketnya
        return view('tiket-berhasil', compact('tiket'));
    }

    public function checkIn($id)
    {
        $tiket = Tiket::findOrFail($id);
        
        // Ubah status tiket
        $tiket->update([
            'status_tiket' => 'Sudah Dipakai'
        ]);

        // Kembalikan ke halaman admin dengan pesan sukses
        return redirect()->back()->with('success', 'Tiket ' . $tiket->kode_tiket . ' berhasil di-Check-in!');
    }
}