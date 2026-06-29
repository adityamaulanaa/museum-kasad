<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\About; 
use Illuminate\Support\Facades\Storage; 

class HalamanController extends Controller
{
    // 1. Tampilkan Halaman Preview About
    public function edit()
    {
        // Langsung ambil data About baris pertama, atau buat objek kosong jika belum ada
        $dataHalaman = About::first() ?? new About();

        return view('admin.kelola_halaman', compact('dataHalaman'));
    }

    // 2. Proses Simpan Perubahan About
    public function update(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $about = About::first() ?? new About();
        $about->judul = $request->judul;
        $about->konten = $request->konten;

        // 🔥 SAMA KAKAY KELOLA BARANG:
        if ($request->hasFile('gambar')) {
            // 🔥 Hapus file lama di dalam folder public/images/about/ jika ada
            if ($about->gambar_about && file_exists(public_path('images/about/' . $about->gambar_about))) {
                unlink(public_path('images/about/' . $about->gambar_about));
            }

            // Bikin nama unik
            $namaFile = 'about_' . time() . '.' . $request->file('gambar')->getClientOriginalExtension();
            
            // 🔥 Pindahkan file langsung ke folder public/images/about/
            $request->file('gambar')->move(public_path('images/about'), $namaFile);
            
            // Di database tetep HANYA menyimpan nama filenya saja
            $about->gambar_about = $namaFile;
        }

        $about->save();

        return redirect()->back()->with('success', "Konten Tentang Museum berhasil diperbarui!");
    }
}